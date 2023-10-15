<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

trait HasImage
{
    public function uploadImage($request)
    {
        $image = null;
        if ($request->file('image')) {
            $image = $request->file('image');
            $filenamewithextension = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $input = Str::slug($filename, '-') . '-' . time() . '.' . $image->getClientOriginalExtension();
            $destination = public_path('upload'); // Ubah direktori tujuan ke "public"
            $img = $image->move($destination, $input);
        }
        if ($request->file('avatar')) {
            $image = $request->file('avatar');
            $filenamewithextension = $request->file('avatar')->getClientOriginalName();
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $input = Str::slug($filename, '-') . '-' . time() . '.' . $image->getClientOriginalExtension();
            $destination = public_path('upload'); // Ubah direktori tujuan ke "public"
            $img = $image->move($destination, $input);
        }
        return $input;
    }

    public function uploadImage2($request, $fieldName)
    {
        // dd($request);
        // dd($fieldName);
        if ($request->file($fieldName)) {
            $image = $request->file($fieldName);
            $filenamewithextension = $image->getClientOriginalName();
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $input = Str::slug($filename, '-') . '-' . time() . '.' . $image->getClientOriginalExtension();
            $destination = public_path('upload'); // Ubah direktori tujuan ke "public"
            $img = $image->move($destination, $input);
            return $input;
        }

        return null;
    }
    public function uploadImage3($request, $fieldName, $index, $field)
    {
        // dd($request);
        // dd($request->file('real')[0]['ktp']);
        if ($request->file($fieldName)[$index][$field]) {
            $image = $request->file($fieldName)[$index][$field];
            $filenamewithextension = $image->getClientOriginalName();
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $input = Str::slug($filename, '-') . '-' . time() . '.' . $image->getClientOriginalExtension();
            $destination = public_path('upload'); // Ubah direktori tujuan ke "public"
            $img = $image->move($destination, $input);
            return $input;
        }

        return null;
    }

    public function deleteImage($data)
    {
        return Storage::delete('public/upload/' . $data);
    }
}
