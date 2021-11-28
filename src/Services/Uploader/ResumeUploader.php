<?php
namespace App\Services\Uploader;

use App\Entity\User;
use App\Utils\Uploader\AbstractUploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ResumeUploader extends AbstractUploader
{

    /**
     * @var string $folder;
     */
    private $folder = '/profile/resume';

    /**
     * @var string $name
     */

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
    public function upload(UploadedFile $file, User $user)
    {
        // Create file directory to store file if directory does not exist
        $this->mkdir($this->getTargetDirectory());
        // Check size and extension of file sent
        $this->checkExtension((string) $file->guessExtension(), 'resume')
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

        if ($user->getResume() !== null) {
            $this->getFilesystem()->remove($this->rootDirectory . $user->getResume());
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
