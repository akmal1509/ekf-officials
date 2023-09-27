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

        // if ($request->file('image')) {
        //     $image = $request->file('image');
        //     $filenamewithextension  = $request->file('image')->getClientOriginalName();
        //     $filename               = pathinfo($filenamewithextension, PATHINFO_FILENAME);
        //     $input     = Str::slug($filename, '-') . '-' . time() . '.' . $image->getClientOriginalExtension();
        //     $destination = 'public/upload';
        //     $img = Storage::putFileAs($destination, $image, $input);
        // }
        if ($request->file('image')) {
            $image = $request->file('image');
            $filenamewithextension = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $input = Str::slug($filename, '-') . '-' . time() . '.' . $image->getClientOriginalExtension();
            $destination = public_path('upload'); // Ubah direktori tujuan ke "public"
            $img = $image->move($destination, $input);
        }


        return $input;
    }

    public function deleteImage($data)
    {
        return Storage::delete('public/upload/' . $data);
    }
}
