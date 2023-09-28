<?php

namespace App\Http\Resources;

use App\Traits\ApiCollectionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => $this->id ?? 1,
            'name' => $this->name,
            'username' => $this->username,
            'phone' => $this->phone,
            'admin' => $this->admin,
            'address' => $this->address,
            'avatar' => $this->avatar ?  asset('upload') . '/' . $this->avatar : '',
            'assignment' => $this->whenLoaded('assignments', function () {
                return $this->assignments->map(function ($assignment) {
                    return [
                        'id' => $assignment->id,
                        'dapil' => [
                            'id' => $assignment->dapils->id,
                            'name' => $assignment->dapil_name
                        ],
                        'province' => [
                            'id' => $assignment->dapils->provinces->id,
                            'name' => $assignment->dapils->provinces->name
                        ],
                        'city' => [
                            'id' => $assignment->dapils->cities->id,
                            'name' => $assignment->dapils->cities->name
                        ],
                        'district' => [
                            'id' => $assignment->districts->id,
                            'name' => $assignment->districts->name,
                            'villages' =>  $assignment->districts->villages->map(function ($village) {
                                return [
                                    'id' => $village->id,
                                    'name' => $village->name
                                ];
                            })
                        ]
                    ];
                });
            })
        ];
    }
}
