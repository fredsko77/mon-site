<?php
namespace App\Services\Admin;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use App\Services\Admin\ProjectServicesInterface;
use App\Utils\ServicesTrait;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Session\Session;
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

    /**
     * @var Filesystem $filesystem
     */
    private $filesystem;

    /**
     * @var ContainerInterface $container
     */
    private $container;

    /**
     * @var Session $session
     */
    private $session;

    /**
     * @var Slugify $slugger
     */
    private $slugger;

    public function __construct(
        EntityManagerInterface $manager,
        SerializerInterface $serializer,
        UrlGeneratorInterface $router,
        ProjectRepository $repository,
        ContainerInterface $container,
        Filesystem $filesystem,
    ) {
        $this->manager = $manager;
        $this->serializer = $serializer;
        $this->router = $router;
        $this->repository = $repository;
        $this->container = $container;
        $this->filesystem = $filesystem;
        $this->session = new Session;
        $this->slugger = new Slugify;
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

    /**
     * @param FormInterface $form
     * @param Project $project
     *
     * @return void
     */
    public function store(FormInterface $form, Project $project): void
    {
        $image = $form->get('uploadedFile')->getData();
        $project->getId() !== null ? $project->setUpdatedAt($this->now()) : $project->setCreatedAt($this->now());

        $project->setSlug(
            $this->slugger->slugify(
                $project->getSlug() ?? $project->getName(),
                '-'
            )
        );

        if ($image instanceof UploadedFile) {

            $filename = md5(uniqid()) . '.' . $image->guessExtension();

            $image->move(
                $this->container->getParameter('project_directory'),
                $filename
            );

            $this->deleteImage($project);

            $project->setImage('/uploads/project/' . $filename);

            $this->session->getFlashBag()->add(
                'info',
                'Le contenu a ??t?? mis ?? jour'
            );
        }

        $this->manager->persist($project);
        $this->manager->flush();
    }

    /**
     * @param Project $project
     *
     * @return object
     */
    public function delete(Project $project): object
    {
        $this->deleteImage($project);

        $this->manager->remove($project);
        $this->manager->flush();

        return $this->sendNoContent();
    }

    /**
     * @param Project $project
     *
     * @return void
     */
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
