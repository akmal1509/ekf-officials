<?php

namespace App\Http\Resources;

use App\Traits\ApiCollectionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CanvasResource extends JsonResource
{
    use ApiCollectionResource;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data =  parent::toArray($request);
        if ($data['ktpImage'] != null) {
            $data['ktpImage'] = asset('upload') . '/' . $data['ktpImage'];
        }
        if ($data['rumahImage'] != null) {
            $data['rumahImage'] = asset('upload') . '/' . $data['rumahImage'];
        }
        if ($data['withImage'] != null) {
            $data['withImage'] = asset('upload') . '/' . $data['withImage'];
        }
        if ($data['kkImage'] != null) {
            $data['kkImage'] = asset('upload') . '/' . $data['kkImage'];
        }
        return $data;
    }
}
