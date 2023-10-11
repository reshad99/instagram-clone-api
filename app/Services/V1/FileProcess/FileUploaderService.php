<?php

namespace App\Services\V1\FileProcess;

use App\Repositories\MediaRepository;
use App\Services\V1\CommonService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

class FileUploaderService extends CommonService
{
    private static $discName = 'public';
    private $file;
    private $acceptedExtensions = ['png', 'jpg', 'jpeg', 'webp'];

    public function __construct(UploadedFile $file = null)
    {
        parent::__construct(new MediaRepository);
        $this->file = $file;
    }

    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function save(Model $model)
    {
        try {
            return DB::transaction(function () use ($model) {
                Log::channel('testing')->info('Model json on File Uploader Service save method: ' . json_encode($model));
                $this->storeOriginalFile();

                if ($this->isImageFile()) {
                    $this->optimizeImage();
                    $pathTitle = 'images/';
                } else {
                    $pathTitle = 'files/';
                }

                $fileData = [
                    'file_size' => $this->getFile()->getSize(),
                    'mime_type' => $this->getFile()->getMimeType(),
                    'extension' => $this->getFile()->getClientOriginalExtension(),
                    'path' => $this->getPath(true, $pathTitle),
                ];

                if ($this->isImageFile()) {
                    $imageDimensions = $this->getImageDimensions();
                    $fileData['width'] = $imageDimensions[0];
                    $fileData['height'] = $imageDimensions[1];
                }

                Log::channel('posts')->info("post model in fileuploader service save : " . json_encode($model));

                return $this->mainRepository->store($fileData, $model);
            });
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    private function getImageDimensions(): array
    {
        list($width, $height) = getimagesize(storage_path('app/' . self::$discName . '/' . $this->getPath(true)));
        return [$width, $height, ($width / $height)];
    }

    private function isImageFile(): bool
    {
        return (substr($this->file->getMimeType(), 0, 5) == 'image');
    }

    private function storeOriginalFile(): void
    {
        $this->file->store($this->getPath(false), self::$discName);
    }

    private function getPath($withName = true, $pathTitle = 'images/'): string
    {
        $path = $pathTitle . Carbon::today()->format('Y/m/d') . '/';
        if ($withName) $path .= $this->file->hashName();

        return $path;
    }

    private function optimizeImage(): void
    {
        if (in_array($this->file->getClientOriginalExtension(), $this->acceptedExtensions)) {
            ImageOptimizer::optimize(storage_path('app/' . self::$discName . '/' . $this->getPath(false)));
        }
    }
}
