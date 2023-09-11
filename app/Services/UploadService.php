<?php

namespace App\Services;

use App\Components\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;

/**
 * Class UploadService
 *
 * @package App\Services
 */
class UploadService
{
    public function __construct(
        private Filesystem $fileUpload
    ) {}

    /**
     * @param $path , $file
     *
     * @return array $images
     */
    public function uploadImage($path, $file)
    {
        return $this->fileUpload->uploadImage($path, $file);
    }

    /**
     * @param $path , $file
     *
     * @return array $file
     */
    public function uploadFiles($path, $file)
    {
        return $this->fileUpload->uploadFile($path, $file);
    }

    /**
     * @param $path
     *
     * @return bool
     */
    public function removeImage($path)
    {
        return $this->fileUpload->remove($path);
    }

    /**
     * @param \Illuminate\Http\UploadedFile $files
     *
     * @return array
     */
    public function uploadImageTemp($files)
    {
        return $this->fileUpload->uploadTemp($files);
    }

    /**
     * @param string $path
     * @param string $url
     *
     * @return array
     */
    public function moveImage($path, $url)
    {
        return $this->fileUpload->moveTempUpload($path, $url);
    }

    /**
     * move images to $path
     *
     * @param $path
     * @param $arr_url
     * @return array
     */
    public function moveImages($path, $arr_url)
    {
        $images = [];
        foreach ($arr_url as $url) {
            $images[] = $this->moveImage($path, $url);
        }

        return $images;
    }

    /**
     * @param \Illuminate\Http\UploadedFile[] $files
     *
     * @return array
     */
    public function image($files)
    {
        $images = $this->fileUpload->uploadTemp($files);
        $images = is_array($images) ? $images : [];

        return array_map(function ($img) {
            return url($img);
        }, $images);
    }

    public function resize($files, $sizes)
    {
        if (!is_array($files)) {
            $files = [$files];
        }

        if (!is_array($sizes)) {
            $sizes = [$sizes];
        }

        foreach ($files as $file) {
            try {
                $file = @public_path($file);
                $pathinfo = @pathinfo($file);
                foreach ($sizes as $size) {
                    $newName = @$pathinfo['dirname'] .
                        '/' . @$pathinfo['filename'] . '_' . $size . '.' . @$pathinfo['extension'];
                    File::copy($file, $newName);
                    $cmd = "convert $file -resize $size\> -auto-orient -size $size"
                        . " xc:" . (@$pathinfo['extension'] == 'png' ? 'transparent' : 'white')
                        . " +swap -gravity center -composite $newName";
                    exec($cmd);
                }
            } catch (\Throwable $th) {
                //
            }
        }
    }

    /**
     * Upload and resize images
     *
     * @param $path
     * @param $arr_url
     * @param $img_size
     * @return array|bool
     */
    public function uploadResizeImages($path, $arr_url, $img_size)
    {
        $images = $this->moveImages($path, $arr_url);
        if (!$images) {
            return false;
        }

        return $this->resize($images, $img_size);
    }
}
