<?php

namespace App\Repositories;

// use App\Console\Commands\AutoUpdate;
use Exception;
use App\Helpers\UserHelper;
use App\Jobs\AutoUpdateJob;
use App\Laravue\Models\Risk;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\MitigationUpdateTrait;
use App\Laravue\Models\RiskMitigation;
use App\Laravue\Models\MitigationUpdate;
use App\Laravue\Models\RiskUpdateProgress;

class MitigationProgressRepository extends BaseRepository
{
    // use MitigationUpdateTrait;
    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected $model;
    protected $model2;
    protected $option;

    public function __construct(MitigationUpdate $model)
    {
        $this->model = $model;
        $this->option['with'] = [
            'riskMitigations',
            'paramsStatus',
            // 'paramsPeriod'
            // 'status'
        ];
        $this->option['withCount'] = [];
    }

    public function autoUpdateRepo($data)
    {
        try {
            $month = $data['month'] ?? null;
            $riskId = $data['riskId'] ?? '';
            if ($month == null) {
                AutoUpdateJob::dispatch($data);
                return $this->setResult('qu')
                    ->setCode(200)
                    ->setMessage('Success')
                    ->setStatus(true);
            } elseif ($month <= 12) {
                try {
                    $result = AutoUpdateJob::dispatch($data);
                } catch (Exception $e) {
                    Log::build([
                        'driver' => 'single',
                        'path' => storage_path('logs/repo.log'),
                    ])->error($e->getMessage());
                }

                if ($result) {
                    return $this->setResult('qu')
                        ->setCode(200)
                        ->setMessage('Success')
                        ->setStatus(true);
                } else {
                    return $this->setResult('failed')
                        ->setCode(200)
                        ->setMessage('Failed')
                        ->setStatus(true);
                }
            } elseif ($month == 99) {
                $stopMonth = (int)date('m');
                $result = array();
                for ($i = 0; $i <= $stopMonth; $i++) {
                    $send = [
                        'month' => $i,
                        'riskId' => $riskId,
                        'option' => true
                    ];
                    AutoUpdateJob::dispatch($send);
                }
                return $this->setResult('qu')
                    ->setCode(200)
                    ->setMessage('Success sad')
                    ->setStatus(true);
            } else {
                $result = '';
                return $this->setResult($result)
                    ->setCode(200)
                    ->setMessage('Input Correct month')
                    ->setStatus(true);
            }
        } catch (Exception $e) {
            Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/repo.log'),
            ])->info($e->getMessage());
            $result = '';
            return $this->setResult($result)
                ->setCode(200)
                ->setMessage('error')
                ->setStatus(true);
        }
    }
    public function autoUpdate($data)
    {
        $month = $data['month'] ?? '';
        $riskId = $data['riskId'] ?? '';
        $yearsCurrent = (int)date('Y');

        if ($month == null) {
            $monthCurrent = (int)date('m');
        } elseif ($month <= 12) {
            $monthCurrent = $month;
        } elseif ($month == 99) {
            $stopMonth = (int)date('m');
            $result = array();
            for ($i = 0; $i <= $stopMonth; $i++) {
                $send = [
                    'month' => $i,
                    'riskId' => $riskId,
                    'option' => true
                ];
                $result[$i] = $this->autoUpdate($send);
            }
            $finalResult = array_filter($result, function ($value) {
                return $value !== null;
            });
            return $this->setResult($finalResult)
                ->setCode(200)
                ->setMessage('Success')
                ->setStatus(true);
        } else {
            $result = '';
            return $this->setResult($result)
                ->setCode(200)
                ->setMessage('Input Correct month')
                ->setStatus(true);
        }

        $monthValidate = $monthCurrent - 1;
        if ($monthValidate == 0) {
            $monthValidate = 12;
            $yearsCurrent = $yearsCurrent - 1;
        }
        $monthYearValidate = $yearsCurrent . '-' . $monthValidate;

        /**
         * 1. (khusus period) Check mitigasi dibulan yang ditentukan (default bulan sekarang - 1)
         * 2. sertakan data orWhere non period
         */
        $mitigationData3 = $this->mitigationPeriod($riskId, $monthValidate, $yearsCurrent);

        $mitigationOnPeriod = array();
        foreach ($mitigationData3 as $mitigationIn) {
            /**
             * Check risk pada mitigasi apakah sudah melewati period(tahun)
             */
            $msg = UserHelper::validMitigationYear($mitigationIn);
            if ($msg == true) {
                array_push($mitigationOnPeriod, $mitigationIn);
            }
        }

        /**
         * Check progress mitigasi dalam periode bulan dan tahun yang sudah terisi
         */
        $progressPeriod = MitigationUpdate::select('mitigation_id')
            ->whereIn('mitigation_id', $mitigationOnPeriod)
            ->where('month', $monthValidate)
            ->where('years', $yearsCurrent)
            ->get()->pluck('mitigation_id')->toArray();

        /**
         * Memisahkan data array mitigasi yang sudah terisi
         */

        $mitigationIdData = array_diff($mitigationOnPeriod,  $progressPeriod);
        $totalMitigationIdData = count($mitigationIdData);
        $counter = 1;

        if ($mitigationIdData ==  null) {
            if (!isset($data['option'])) {
                $result = 'Auto Update Success';
                return $this->setResult($result)
                    ->setCode(200)
                    // ->setMessage('Auto Update Success')
                    ->setStatus(true);
            } else {
                return;
            }
        }
        $onResult = 'success input :' . $monthValidate . '-' . $yearsCurrent;
        /**
         * Start Proses Input Auto Update
         */
        foreach ($mitigationIdData as $mitigationId) {
            $checkRiskMitigation = RiskMitigation::where('mitigation_id', $mitigationId)
                ->first();

            $checkMitigationBefore = MitigationUpdate::where('mitigation_id', $mitigationId)
                ->where('month', '<', $monthValidate)
                ->orderBy('month', 'DESC')
                //     ->orderByRaw("CASE
                //     WHEN month >= $monthValidate THEN month - $monthValidate
                //     ELSE 9999
                // END")
                ->first();

            $month_select = strval($monthValidate);
            $years_select = strval($yearsCurrent);

            $now_select = strtotime("01-" . $month_select . "-" . $years_select);
            $start_date = strtotime($checkRiskMitigation->start_date);
            $end_date = strtotime($checkRiskMitigation->end_date);
            $duedate_type = $checkRiskMitigation->duedate_type_id;
            $progressActualPeriod = $checkMitigationBefore->progress_actual ?? 0;
            $progressPlanBefore = $checkMitigationBefore->progress_plan ?? 0;
            $checkMonthBefore = $checkMitigationBefore->month ?? 0;
            $progress_plan = $this->formulaProgressPlan($now_select, $start_date, $end_date, $duedate_type, $progressActualPeriod, $progressPlanBefore, $checkMonthBefore);
            $bulan = strlen($monthValidate);
            if ($bulan == 1) {
                $monthValidate = '0' . $monthValidate;
            }

            $dataInsert = [
                'mitigation_id' => $mitigationId,
                'mitigation_status_progress_id' => 25, //on going
                'progress_plan' => $progress_plan,
                'remark_progress' => "Created Automatically by System",
                'month' => $monthValidate,
                'years' => $yearsCurrent,
            ];
            $realActual = $checkMitigationBefore->progress_actual ?? 0;
            // if ($checkMitigationBefore->month > $monthValidate) {
            //     $realActual = 0;
            // }

            if ($checkMitigationBefore) {
                if ($checkMitigationBefore->month > $monthValidate) {
                    $realActual = 0;
                }
                $dataInsert['progress_actual'] = $realActual;
                if ($checkRiskMitigation->duedate_type_id !== 5) {
                    $dataInsert['progress_actual'] = 0;
                }
                try {
                    DB::table('mitigation_progress')->insert($dataInsert);
                } catch (Exception $e) {
                    Log::channel('repo_error')->info('error when insert mitigation progress on mitigation_id' . ' ' .  $mitigationId . ' messages: ' . $e->getMessage());
                    Log::channel('repo_error')->info('jumlah data yang harus masuk :' . $totalMitigationIdData . ', jumlah data yang masuk' . $counter);
                    return $this->exceptionResponse($e);
                }
            } else {
                $dataInsert['progress_actual'] = 0;
                try {
                    DB::table('mitigation_progress')->insert($dataInsert);
                } catch (Exception $e) {
                    Log::channel('repo_error')->info('error when insert mitigation progress on mitigation_id' . ' ' .  $mitigationId . ' messages: ' . $e->getMessage());
                    Log::channel('repo_error')->info('jumlah data yang harus masuk :' . $totalMitigationIdData . ', jumlah data yang masuk' . $counter);
                    return $this->exceptionResponse($e);
                }
            }

            $risk = RiskMitigation::where('mitigation_id', $mitigationId)->first();
            $risk_id = $risk->risk_id;
            $count = RiskMitigation::where('risk_id', $risk_id)
                ->where('is_parent', '!=', 1)
                ->whereHas('mitigationProgress', function ($query) use ($monthValidate, $yearsCurrent) {
                    $query->where('month', $monthValidate)
                        ->where('years', $yearsCurrent);
                })
                ->count();

            $progress = DB::table('risk')
                ->leftJoin('risk_mitigation as rm', 'rm.risk_id', '=', 'risk.risk_id')
                ->leftJoin('mitigation_progress as mp', 'mp.mitigation_id', '=', 'rm.mitigation_id')
                ->where('risk.risk_id', $risk_id)
                ->where('rm.is_parent', '!=', 1)
                ->where('mp.month', $monthValidate)
                ->where('mp.years', $yearsCurrent)
                ->select(
                    DB::raw('SUM(mp.progress_actual) AS progress_actual'),
                    DB::raw('SUM(mp.progress_plan) AS progress_plan')
                )
                ->first();
            if ($count == 0) {
                $progress_actual = 0;
                $progress_plan = 100;
            } else {
                $progress_actual = $progress->progress_actual / $count;
                $progress_plan = $progress->progress_plan /  $count;
                if ($progress_plan > 100) {
                    $progress_plan = 100;
                } else if ($progress_plan < 0) {
                    $progress_plan = 0;
                }
            }

            if ($progress_actual < 100 && $progress_actual >= $progress_plan) {
                $mitstat_risk = "On Going : Ontime";
            } elseif ($progress_actual < 100 && $progress_actual < $progress_plan) {
                $mitstat_risk = "On Going : Behind Schedule";
            } else {
                $mitstat_risk = "Complete";
            }

            $cekriskupdate = RiskUpdateProgress::where('risk_id', $risk_id)->where('month', $monthValidate)
                ->where('years', $yearsCurrent)->first();
            $riskdata = Risk::where('risk_id', $risk_id)->first();
            if (empty($cekriskupdate)) {
                $likelihood_id = $riskdata->ra_residual_likelihood_id;
                $severity_id = $riskdata->ra_residual_severity_id;
                $risk_rank = $riskdata->ra_residual_risk_rank;
                $risk_rank_desc = $riskdata->ra_residual_risk_rank_description_estimate;
            } else {
                $likelihood_id = $cekriskupdate->likelihood_id;
                $severity_id = $cekriskupdate->severity_id;
                $risk_rank = $cekriskupdate->risk_rank;
                $risk_rank_desc = $cekriskupdate->risk_rank_desc;
            }

            DB::table('risk_update_progress')
                ->updateOrInsert(
                    ['risk_id' => $risk_id, 'month' => $monthValidate, 'years' => $yearsCurrent],
                    [
                        'risk_id' => $risk_id,
                        'mitigation_status_per_risk_id' => $mitstat_risk,
                        'month' => $monthValidate,
                        'years' => $yearsCurrent,
                        'likelihood_id' => $likelihood_id,
                        'severity_id' => $severity_id,
                        'risk_rank' => $risk_rank,
                        'risk_rank_desc' => $risk_rank_desc,
                        'progress_plan_per_risk' => $progress_plan,
                        'progress_actual_per_risk' => $progress_actual,
                    ]
                );
            $counter++;
        }
        if ($counter = $totalMitigationIdData) {
            Log::channel('repo')->info('jumlah data yang harus masuk :' . $totalMitigationIdData . ', jumlah data yang masuk' . $counter);
        }

        if (!isset($data['option'])) {
            $result = 'Auto Update Success';
            return $this->setResult($result)
                ->setCode(200)
                // ->setMessage('Auto Update Success')
                ->setStatus(true);
        } else {
            return  $onResult;
        }
    }

    public function formulaProgressPlan($now_select, $start_date, $end_date, $duedate_type, $progressActualPeriod, $progressPlanBefore, $checkMonthBefore)
    {

        $nowyear = date('Y', $now_select);
        $nowmonth = date('m', $now_select);

        $year1 = date('Y', $start_date);
        $year2 = date('Y', $end_date);

        $month1 = date('m', $start_date);
        $month2 = date('m', $end_date);

        $diff = (($year2 - $year1) * 12) + ($month2 - $month1 + 1); // hitung jumlah bulan dari start sampai end

        //echo $now = date("m", $end_date) - date("m", $start_date);
        $diff1 = (($nowyear - $year1) * 12) + ($nowmonth - $month1 + 1); //hitung jumlah bulan berjalan dari startdate
        //dd("jumlah bulan ". $diff . " jml bulan berjalan ".$diff1);
        if ($duedate_type == 5) { //range
            if ($diff1 < 1) { //jika belum masuk ke period start date nya
                $progress_plan = 0;
            }
            $progress_plan = round(($diff1 / $diff) * 100, 2);

            if ($progressActualPeriod == 100) {
                $progress_plan = $progressPlanBefore;
            }

            if ($progress_plan > 100) { //jika period sudah lewat dari end date
                $progress_plan = 100;
            }
            if ($checkMonthBefore > $nowmonth) {
                $progress_plan = round(($diff1 / $diff) * 100, 2);
            }
        } else {
            $progress_plan = 100;
        }
        return $progress_plan;
    }
    public function mitigationPeriod($riskId, $monthValidate, $yearsCurrent)
    {
        $mitigationPeriod = RiskMitigation::with(['risks', 'mitigationProgress'])
            ->whereHas('risks', function ($query) use ($riskId, $yearsCurrent) {
                if ($riskId != null) {
                    $query->where('rr_risk_status', 17)
                        ->whereIn('risk_id', [$riskId])
                        ->where('period', '<=', $yearsCurrent);
                } else {
                    $query->where('rr_risk_status', 17);
                }
            })
            ->whereRaw("DATE_FORMAT(start_date, '%m') <= ?", [$monthValidate])
            ->whereRaw("DATE_FORMAT(start_date, '%Y') <= ?", [$yearsCurrent])
            // ->whereRaw("DATE_FORMAT(end_date, '%m') >= ?", [$monthValidate])
            // ->whereRaw("DATE_FORMAT(end_date, '%Y') <= ?", [$yearsCurrent])
            ->where('duedate_type_id', '5')
            ->get()->pluck('mitigation_id')->toArray();

        $mitigationPeriod2 = RiskMitigation::with(['risks', 'mitigationProgress'])
            ->whereHas('risks', function ($query) use ($riskId) {
                if ($riskId != null) {
                    $query->where('rr_risk_status', 17)
                        ->whereIn('risk_id', [$riskId]);
                } else {
                    $query->where('rr_risk_status', 17);
                }
            })
            ->whereMonth('created_at', '<=', $monthValidate)
            ->whereYear('created_at', '<=', $yearsCurrent)
            ->where('duedate_type_id', '!=', '5')
            ->get()->pluck('mitigation_id')->toArray();
        $mitigationData3 = array_merge($mitigationPeriod, $mitigationPeriod2);

        return $mitigationData3;
    }
}
