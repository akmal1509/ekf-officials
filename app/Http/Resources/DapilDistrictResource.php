<?php

namespace App\Http\Resources;

use App\Traits\ApiCollectionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DapilDistrictResource extends JsonResource
{
    use ApiCollectionResource;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
