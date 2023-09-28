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
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'phone' => $this->phone,
            'admin' => $this->admin,
            'address' => $this->address,
            'avatar' => $this->avatar,
            'assignment' => $this->whenLoaded('assignments', function () {
                return $this->assignments->map(function ($assignment) {
                    // $dapil =  $assignment->dapils->map(function ($dapil) {
                    //     return;
                    //     // return [
                    //     //     'province' => [
                    //     //         'id' => $dapil->provinces->id
                    //     //     ]
                    //     // ];
                    // });
                    // $dapil = $assignment->dapils->provinces->map(function ($village) {
                    //     return [
                    //         'id' => $village->id,
                    //         'name' => $village->name
                    //     ];
                    // });
                    // $village = $assignment->districts->villages->map(function ($village) {
                    //     return [
                    //         'id' => $village->id,
                    //         'name' => $village->name
                    //     ];
                    // });
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
            // 'assignment' => $this->when($this->relationLoaded('assignments'), function () {
            //     return $this->assignments->map(function ($assignment) {
            //         return [
            //             'id' => $assignment->id,
            //             'district' => [
            //                 'id' => $assignment->
            //             ]
            //         ];
            //     });
            // })
            // 'assignment' => $this->whenLoaded('assignments', function(){
            //     return[
            //         'district' => $this->relation
            //     ]
            // })
            // 'assignment' => $this->whenLoaded('assignments', function () {
            //     return $this->assignments->map(function ($assignment) {
            //         return [
            //             'id' => $assignment->id,
            //             'district' => $assignment->whenLoaded('districts', function () use ($assignment) {
            //                 return $assignment->districts->map(function ($distrist) {
            //                     return [
            //                         'id' => $distrist->id
            //                     ];
            //                 });
            //             })
            //         ];
            //     });
            // })
            // 'assignment' => $this->whenLoaded('assignments', function () {
            //     return [
            //         'id' => $this->id,
            //         'district' => $this->relationLoaded('districts', function () {
            //             return [
            //                 'id' => $this->id
            //             ];
            //         })
            //     ];
            // }),
            // 'at' => $this->whenLoaded('assignments.districts', function () {
            //     $data = [
            //         'id' => $this->id,
            //         // 'district' => $this->whenLoaded('districts', function () {
            //         //     $data = [
            //         //         'id' => $this->id
            //         //     ];
            //         //     return $data;
            //         // })
            //     ];
            //     return $data;
            // })

            // 'assignment' => AssignmentResource::collection($this->whenLoaded('assignments')),
            // 'villages' => VillageResource::collection($this->whenLoaded('villages'))
        ];
    }
}
