<?php
namespace App\Services\Uploader;

use App\Entity\Content;
use App\Utils\Uploader\AbstractUploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProfileUploader extends AbstractUploader
{

    /**
     * @var string $folder;
     */
    private $folder = '/profile/image';

    public function __construct($targetDirectory, $rootDirectory)
    {
        $this->targetDirectory = $targetDirectory;
        $this->rootDirectory = $rootDirectory;
    }

    /**
     * @param UploadedFile $file
     *
     * @return mixed
     */
    public function upload(UploadedFile $file, Content $content)
    {
        // Create file directory to store file if directory does not exist
        $this->mkdir($this->getTargetDirectory());
        // Check size and extension of file sent
        $this->checkExtension((string) $file->guessExtension(), 'image')
            ->checkSize($this->mb($file))
        ;

        if (count($this->getErrors()) > 0) {
            return $this->getErrors();
        }

        $this->setFilename($file);

        $file->move(
            $this->getTargetDirectory(),
            $this->getFilename()
        );

        if ($content->getImage() !== null) {
            $this->getFilesystem()->remove($this->rootDirectory . $content->getImage());
        }

        return $this->path();
    }

    /**
     * @return string
     */
    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }

    public function path(): string
    {
        return '/uploads' . $this->folder . '/' . $this->getFilename();
    }

}
