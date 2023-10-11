<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Traits\ApiCollectionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AssignmentResource extends JsonResource
{
    use ApiCollectionResource;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'dapilsName' => $this->dapilName,
            'dapilDistricts' => $this->dapils->id,
            'users' => $this->whenLoaded('users', function () {
                return [
                    'id' => $this->users->id,
                    'name' => $this->users->name
                ];
            }),
            'districts' => $this->whenLoaded('districts', function () {
                return [
                    'id' => $this->districts->id,
                    'name' => $this->districts->name
                ];
            })
        ];
    }
}
