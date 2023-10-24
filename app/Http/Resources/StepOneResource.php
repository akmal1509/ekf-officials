<?php

namespace App\Http\Resources;

use App\Traits\ApiCollectionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StepOneResource extends JsonResource
{
    use ApiCollectionResource;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);
        if ($this->verify == 0) {
            $ver = 'Belum diverifikasi';
        } else {
            $ver = 'Sudah diverifikasi';
        }
        if ($this->calculate() == 100) {
            $com = 'Sudah lengkap';
        } else {
            $com = 'Belum lengkap';
        }
        $data['complete'] = $this->calculate();
        $data['comtext'] = $com;
        $data['verificate'] = $ver;
        if ($data['image'] != null) {
            $data['image'] = asset('upload') . '/' . $data['image'];
        }
        return $data;
    }
}
