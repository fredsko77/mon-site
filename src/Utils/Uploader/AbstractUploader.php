<?php
namespace App\Utils\Uploader;

use App\Utils\ServicesTrait;
use Cocur\Slugify\Slugify;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

abstract class AbstractUploader
{

    use ServicesTrait;

    const MAX_FILE_SIZE = 20;

    /**
     * @var array $errors
     */
    protected $errors = [];

    /**
     * @var string $filename
     */
    protected $filename;

    /**
     * @var string $targetDirectory
     */
    protected $targetDirectory;

    /**
     * @param string $fileExtension
     *
     * @return self
     */
    protected function checkExtension(string $fileExtension = '', string $type = 'default')
    {
        if ($type === 'image') {
            if (!in_array($fileExtension, $this->getImageExtenxion())) {
                $this->setErrors('security', 'This image is not valid !');
            }
        }
        if ($type === 'default') {
            if (in_array($fileExtension, $this->getExcludedFile())) {
                $this->setErrors('security', 'Try to upload a harmful file !');
            }
        }

        return $this;
    }

    /**
     * @return Filesystem
     */
    public function getFilesystem(): Filesystem
    {
        return new Filesystem;
    }

    /**
     * @return float $bytes
     */
    protected function mb(UploadedFile $file): float
    {
        return number_format($file->getSize() / 1048576, 2);
    }

    /**
     * @return void
     */
    protected function mkdir(string $directory)
    {
        return $this->getFilesystem()->mkdir($directory);
    }

    /**
     * @param int $size
     *
     * @return self
     */
    protected function checkSize(int $size = 0): self
    {
        if ($size > self::MAX_FILE_SIZE) {
            $this->setErrors('size', 'File is too heavy !');
        }

        return $this;
    }

    /**
     * @param string $key
     * @param string $error
     *
     * @return self
     */
    protected function setErrors(string $key = '', string $error = ''): self
    {
        $this->errors[$key] = $error;

        return $this;
    }

    /**
     * @return array
     */
    protected function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Get $filename
     *
     * @return  string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set $filename
     *
     * @param  string  $filename
     *
     * @return  self
     */
    public function setFilename(UploadedFile $file)
    {
        $filename = explode('.', $file->getClientOriginalName())[0] . '_' . md5(uniqid($this->generateShuffleChars(5)));
        $this->filename = (new Slugify)->slugify($filename, '_') . '.' . $file->guessExtension();

        return $this;
    }

    protected function getExcludedFile(): array
    {
        return [
            'bat',
            'exe',
            'git',
            'htaccess',
            'html',
            'ini',
            'java',
            'js',
            'json',
            'jsx',
            'php',
            'py',
            'sh',
            'sql',
            'xml',
            'yaml',
        ];
    }

    public function getImageExtenxion(string $extension = ''): array
    {
        return [
            'tif',
            'tiff',
            'bmp',
            'jpg',
            'jpeg',
            'gif',
            'png',
            'webp',
            'svg',
        ];
    }

}
