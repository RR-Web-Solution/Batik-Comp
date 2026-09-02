<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

trait HasImageUpload
{
    private function storeUploadedImage(UploadedFile $image, string $prefix = 'product_'): string
    {
        $filename = $prefix.time().'_'.bin2hex(random_bytes(4)).'.'.$image->getClientOriginalExtension();
        File::ensureDirectoryExists(public_path('uploads'));
        $image->move(public_path('uploads'), $filename);

        return $filename;
    }

    private function deleteUploadedImage(?string $image): void
    {
        if ($image && file_exists(public_path('uploads/'.$image))) {
            unlink(public_path('uploads/'.$image));
        }
    }

    private function validateImage(UploadedFile $image): bool
    {
        return in_array($image->getMimeType(), ['image/jpeg', 'image/png', 'image/webp']);
    }
}
