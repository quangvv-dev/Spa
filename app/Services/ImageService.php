<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ImageService
{
    public function store($image, $folder)
    {
        Log::info($folder . "/" . $image->getClientOriginalName() . ", " . $image->getClientMimeType());

        $newImage = Image::make($image->getRealPath());
        $newImage->resize(3000, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        if (!File::exists($folder)) {
            File::makeDirectory($folder, 0755, true);
        }

        $fileName = $this->getFileName($image);
        $newImage->save($folder . '/' . $fileName);

        return $fileName;
    }

    private function getFileName($image)
    {
        $pathInfo = pathinfo($image->getClientOriginalName());
        return Str::slug($pathInfo['filename'] . '-' . Str::random(3)) . '.' . Str::lower($pathInfo['extension']);
    }
}
