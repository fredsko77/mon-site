<?php
namespace App\Services\Uploader;

use App\Entity\Project;
use App\Entity\ProjectImage;
use App\Utils\Uploader\AbstractUploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProjectUploader extends AbstractUploader
{

    /**
     * @var string $folder;
     */
    private $folder = '/project';

    /**
     * @var Project $project
     */
    private $project;

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
    public function upload(UploadedFile $file, Project $project, ?ProjectImage $image = null)
    {
        $this->setProject($project);
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

        if ($image !== null) {
            $this->remove($image);
        }

        return ($image ?? (new ProjectImage))
            ->setPath($this->path())
            ->setOriginalName($this->getFilename())
        ;
    }

    /**
     * @return string
     */
    public function getTargetDirectory(): string
    {
        return $this->targetDirectory . '/' . $this->getProject()->getId();
    }

    /**
     * @return string
     */
    public function path(): string
    {
        return '/uploads' . $this->folder . '/' . $this->getProject()->getId() . '/' . $this->getFilename();
    }

    /**
     * @param ProjectImage $image
     *
     * @return void
     */
    public function remove(ProjectImage $image): void
    {
        $dir = $this->rootDirectory . $image->getPath();
        if ($this->getFilesystem()->exists($dir)) {
            $this->getFilesystem()->remove($dir);
        }
    }

    /**
     * @param Project $project
     *
     * @return void
     */
    public function removeProject(Project $project): void
    {
        $dir = $this->rootDirectory . '/uploads' . $this->folder . '/' . 1 . '/';

        if ($this->getFilesystem()->exists($dir)) {
            $this->getFilesystem()->remove($dir);
        }
    }

    /**
     * Get $project
     *
     * @return  Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param  Project  $project
     *
     * @return  self
     */
    public function setProject(Project $project)
    {
        $this->project = $project;

        return $this;
    }
}
