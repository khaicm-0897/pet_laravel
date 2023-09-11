<?php

namespace App\Components\Filesystem;

use App\Constants\DirectoryConstant;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class Filesystem
{
    /**
     * @param string $path
     * @param string $url
     *
     * @return string|null
     */
    public function moveTempUpload($path, $url)
    {
        $absolutePath = str_replace(url('/'), '', $url);
        $relativePath = $this->uploadPath($absolutePath);
        if (!is_dir('../public/' . $path)) {
            mkdir('../public/' . $path, 0777, true);
        }
        if (File::exists($relativePath)) {
            $newFile = $path . $this->createFileName($path, File::extension($relativePath));

            File::move($relativePath, $this->uploadPath($newFile));

            return $newFile;
        }

        return null;
    }

    /**
     * @param \Illuminate\Http\UploadedFile|array $input
     *
     * @return array|string
     */
    public function uploadTemp($input)
    {
        $absolutePath = DirectoryConstant::TMP_IMAGE;
        if (!is_dir('../public/' . $absolutePath)) {
            mkdir('../public/' . $absolutePath, 0777, true);
        }
        if (is_array($input)) {
            $data = [];
            foreach ($input as $val) {
                $newFile = $this->uploadTemp($val);

                if (!empty($newFile)) {
                    array_push($data, $newFile);
                }
            }

            return $data;
        }

        if (!$input instanceof UploadedFile) {
            return null;
        }

        $relativePath = $this->uploadPath($absolutePath);

        $prefix = date('Y-m-d_');
        $fileName = $this->createFileName($relativePath, $input->getClientOriginalExtension(), $prefix);

        $input->move($relativePath, $fileName);

        return $absolutePath . $fileName;
    }

    /**
     * @param \Illuminate\Http\UploadedFile|array $input
     * @param                                     $directory
     *
     * @return array|string
     */
    public function uploadImage($directory, $input)
    {
        if (is_array($input)) {
            $data = [];
            foreach ($input as $val) {
                $newFile = $this->uploadImage($directory, $val);

                if (!empty($newFile)) {
                    array_push($data, $newFile);
                }
            }

            return $data;
        }

        if (!$input instanceof UploadedFile) {
            return null;
        }

        $relativePath = $this->uploadPath($directory);

        $prefix = date('Y-m-d_');
        $fileName = $this->createFileName($relativePath, $input->getClientOriginalExtension(), $prefix);

        $input->move($relativePath, $fileName);

        return $directory . $fileName;
    }

    /**
     * @param \Illuminate\Http\UploadedFile|array $input
     * @param                                     $directory
     *
     * @return array|string
     */
    public function uploadFile($directory, $input)
    {
        if (is_array($input)) {
            $data = [];
            foreach ($input as $val) {
                $newFile = $this->uploadFile($directory, $val);

                if (!empty($newFile)) {
                    array_push($data, $newFile);
                }
            }

            return $data;
        }

        if (!$input instanceof UploadedFile) {
            return null;
        }

        $relativePath = $this->uploadPath($directory);

        $prefix = date('Y-m-d_');
        $fileName = $this->createFileName($relativePath, $input->getClientOriginalExtension(), $prefix);

        $input->move($relativePath, $fileName);

        return $directory . $fileName;
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    public function remove($path)
    {
        $newPath = $this->uploadPath($path);

        if (File::exists($newPath)) {
            return File::delete($newPath);
        }

        return false;
    }

    /**
     * @param string $path
     * @param string $extension
     * @param string $prefix
     *
     * @return string
     */
    private function createFileName($path, $extension, $prefix = '')
    {
        do {
            $fileName = uniqid($prefix) . '.' . $extension;
        } while ($this->fileExists($path . $fileName));

        return $fileName;
    }

    /**
     * @param string|null $path
     *
     * @return string
     */
    private function uploadPath($path = null)
    {
        return base_path(DirectoryConstant::UPLOAD_PATH . $path);
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    private function fileExists($path)
    {
        return File::exists($this->uploadPath($path));
    }
}
