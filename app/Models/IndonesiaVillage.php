<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravolt\Indonesia\Models\District;

class IndonesiaVillage extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    // protected $table = []

    public function stepOne()
    {
        return $this->hasMany(StepOne::class, 'villageId', 'id');
    }

    public function verifStepOne()
    {
        return $this->hasMany(StepOne::class, 'villageId', 'id')->where('verify', true);
    }

    public function districts()
    {
        return $this->belongsTo(IndonesiaDistrict::class, 'district_code', 'code');
    }
}
