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
        return $this->saveUploadedFile($input, DirectoryConstant::TMP_IMAGE);
    }
    public function saveUploadedFile($files, $saveTo)
    {
        if (is_array($files)) {
            return collect($files)
                ->map(function ($file) use ($saveTo) {
                    return $this->saveUploadedFile($file, $saveTo);
                })
                ->filter()
                ->all();
        }
        if (!$files instanceof UploadedFile) {
            return null;
        }
        $relativePath = $this->uploadPath($saveTo);
        $prefix = date('Y-m-d_');
        $fileName = $this->createFileName($relativePath, $files->getClientOriginalExtension(), $prefix);
        $files->move($relativePath, $fileName);
        return $saveTo . $fileName;
    }

    /**
     * @param \Illuminate\Http\UploadedFile|array $input
     *
     * @return array|string
     */
    public function uploadUserImage($input)
    {
        return $this->saveUploadedFile($input, DirectoryConstant::USER_IMAGE);
    }

    public function uploadDocumentFile($input)
    {
        return $this->saveUploadedFile($input, DirectoryConstant::DOCUMENT_FILE);
    }
    public function uploadCommentImage($input)
    {
        return $this->saveUploadedFile($input, DirectoryConstant::COMMENT_IMAGE);
    }

    /**
     * @param \Illuminate\Http\uploadVideo|array $input
     *
     * @return array|string
     */
    public function uploadVideo($input)
    {
        return $this->saveUploadedFile($input, DirectoryConstant::TMP_VIDEO);
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
