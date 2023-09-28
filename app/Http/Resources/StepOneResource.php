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
        if ($data['image'] != null) {
            $data['image'] = asset('upload') . '/' . $data['image'];
        }
        return $data;
    }
}
