<?php

namespace App\Traits;

use App\Http\Resources\Paginate;
use Illuminate\Validation\Rules\Exists;

trait ApiCollectionResource
{
    public static function apiCollection($resource)
    {
        $result = self::collection($resource['data']);
        return response()->json([
            'success' => $resource['success'],
            'code' => $resource['code'],
            "data" =>  $result
        ], $resource['code']);
    }

    public static function paginateCollection($resource)
    {
        $result = self::collection($resource['data']);
        $data = [
            'success' => $resource['success'],
            'code' => $resource['code'],
            'paginate' => new Paginate($resource['data']),

            "data" =>  $result
        ];
        if (isset($resource['countData'])) {
            $data['countData'] = $resource['countData'];
        }
        return response()->json($data, $resource['code']);
    }

    public static function otherCollection($resource)
    {
        $result = self::make($resource['data']);
        return response()->json([
            'success' => $resource['success'],
            'code' => $resource['code'],
            'message' => $resource['message'],
            "data" =>  $result
        ], $resource['code']);
    }
}
