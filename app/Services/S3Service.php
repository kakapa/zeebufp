<?php

namespace App\Services;

use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class S3Service
{
    private $disk;

    public function __construct()
    {
        $this->disk = Storage::disk('s3');
    }

    public function storeFile(string $folder, $file, string $filename): string
    {
        // Put the file with the custom filename
        return $this->disk->putFileAs($folder, new File($file), $filename);
    }

    public function retrieveFile($filename)
    {
        return $this->disk->get($filename);
    }

    public function retrieveUrl($filename)
    {
        return $this->disk->url($filename);
    }

    public function fileExists($filename)
    {
        return $this->disk->exists($filename);
    }

    public function deleteFile($filename)
    {
        return $this->disk->delete($filename);
    }

    public function generateTemporaryUrl($filename, $duration)
    {
        return $this->disk->temporaryUrl($filename, now()->addMinutes($duration));
    }
}
