<?php
namespace App\Services\Admin;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use App\Services\Admin\ProjectServicesInterface;
use App\Utils\ServicesTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProjectServices implements ProjectServicesInterface
{

    use ServicesTrait;

    /**
     * @var EntityManagerInterface $manager
     */
    private $manager;

    /**
     * @var SerializerInterface $serializer
     */
    private $serializer;

    /**
     * @var UrlGeneratorInterface $router
     */
    private $router;

    /**
     * @var ValidatorInterface $validator
     */
    private $validator;

    /**
     * @var ProjectRepository $repository
     */
    private $repository;

    public function __construct(
        EntityManagerInterface $manager,
        SerializerInterface $serializer,
        UrlGeneratorInterface $router,
        ValidatorInterface $validator,
        ProjectRepository $repository,
    ) {
        $this->manager = $manager;
        $this->serializer = $serializer;
        $this->router = $router;
        $this->validator = $validator;
        $this->repository = $repository;
    }

    /**
     * @return array
     */
    public function listProjects(): array
    {
        return [
            'projects' => $this->repository->findAll(),
        ];
    }

    public function store(FormInterface $form, Project $project)
    {

    }

    public function delete(Project $project)
    {

    }

    private function deleteImage(Project $project): void
    {
        if ($project->getImage() !== null) {
            $file = $this->container->getParameter('root_directory') . $project->getImage();
            if ($this->filesystem->exists($file)) {
                $this->filesystem->remove($file);
            }
        }
    }

}
