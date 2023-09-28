<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssignmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // $village = [];
        // foreach ($request as $dv) {
        //     $village['id'] = $dv->id;
        //     $village['name'] = $dv->name;
        // }
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            // 'province' => $this->whenLoaded('dapils.provinces', function () {
            //     $data = [
            //         'id' => $this->dapils->provinces->id,
            //         'name' => $this->dapils->provinces->name
            //     ];
            //     return $data;
            // }),
            // 'city' => $this->whenLoaded('dapils.cities', function () {
            //     $data = [
            //         'id' => $this->dapils->cities->id,
            //         'name' => $this->dapils->cities->name
            //     ];
            //     return $data;
            // }),

            // 'location' => DistrictResource::collection($this->whenLoaded('districts')),

            'location' =>  [
                'province' => $this->whenLoaded('dapils.provinces', function () {
                    return [
                        'id' => $this->id,
                        'name' => $this->name
                    ];
                }),
                'city' => $this->whenLoaded('cities', function () {
                    return [
                        'id' => $this->id,
                        'name' => $this->name
                    ];
                }),
                'district' => DistrictResource::make($this->whenLoaded('districts')),
                // 'district' => $this->districts->id,
                // 'villages' => VillageResource::collection($this->whenLoaded('villages'))

            ],

            // 'villages' => VillageResource::collection($this->whenLoaded('villages'))

        ];
    }
}
