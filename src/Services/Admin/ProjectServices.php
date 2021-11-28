<?php
namespace App\Services\Admin;

use App\Entity\Project;
use App\Entity\ProjectImage;
use App\Entity\ProjectTask;
use App\Repository\ProjectImageRepository;
use App\Repository\ProjectRepository;
use App\Services\Admin\ProjectServicesInterface;
use App\Services\Uploader\ProjectUploader;
use App\Utils\ServicesTrait;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @var ProjectUploader $uploader
     */
    private $uploader;

    /**
     * @var ProjectImageRepository $imageRepository
     */
    private $imageRepository;

    public function __construct(
        EntityManagerInterface $manager,
        SerializerInterface $serializer,
        UrlGeneratorInterface $router,
        ValidatorInterface $validator,
        ProjectRepository $repository,
        ProjectUploader $uploader,
        ProjectImageRepository $imageRepository
    ) {
        $this->manager = $manager;
        $this->serializer = $serializer;
        $this->router = $router;
        $this->validator = $validator;
        $this->repository = $repository;
        $this->uploader = $uploader;
        $this->imageRepository = $imageRepository;
    }

    public function listProjects(): array
    {
        return [
            'projects' => $this->repository->findAll(),
        ];
    }

    /**
     * @param Project $project
     *
     * @return array
     */
    public function edit(Project $project): array
    {
        $states = Project::states();
        $visibilities = Project::visibilities();

        return compact('states', 'visibilities', 'project');
    }

    /**
     * @param Request $request
     *
     * @return object
     */
    public function create(Request $request): object
    {
        $data = json_decode($request->getContent());
        $project = (new Project)->setName(property_exists($data, 'name') ? $data->name : null);

        $violations = $this->filterViolations($this->validator->validate($project));

        if (count($violations) > 0) {
            return $this->sendViolations($violations);
        }

        $project
            ->setState(Project::STATE_DEVELOPMENT)
            ->setSlug((new Slugify)->slugify($project->getName()))
            ->setCreatedAt($this->now())
            ->setVisibility(Project::VISIBILITY_PUBLIC)
        ;

        $this->manager->persist($project);
        $this->manager->flush();

        return $this->sendJson(
            $project,
            Response::HTTP_CREATED,
            [
                'Location' => $this->router->generate('admin_project_edit', [
                    'id' => $project->getId(),
                ], UrlGenerator::ABSOLUTE_URL),
            ]
        );
    }

    /**
     * @param Request $request
     * @param Project $project
     *
     * @return object
     */
    public function store(Request $request, Project $project): object
    {
        $project = $this->serializer->deserialize($request->getContent(), Project::class, 'json', ['object_to_populate' => $project]);
        $violations = $this->filterViolations($this->validator->validate($project));

        if (count($violations) > 0) {
            return $this->sendViolations($violations);
        }

        $project
            ->setSlug((new Slugify)->slugify($project->getSlug()))
            ->setUpdatedAt($this->now())
        ;

        $this->manager->persist($project);
        $this->manager->flush();

        return $this->sendJson(
            $project,
            Response::HTTP_OK,
            [
                'Project-Link' => $this->router->generate('project_show', [
                    'id' => $project->getId(),
                    'slug' => $project->getSlug(),
                ], UrlGenerator::ABSOLUTE_URL),
            ]
        );
    }

    /**
     * @param Project $project
     *
     * @return object
     */
    public function delete(Project $project): object
    {
        // Supprimer le dossier contenant les images du projet
        $this->uploader->removeProject($project);

        // Supprimer le projet ainsi ques ses images et ses tâches
        $this->manager->remove($project);
        $this->manager->flush();

        return $this->sendNoContent();
    }

    /**
     * @param Project $project
     * @param Request $request
     *
     * @return object
     */
    public function createTask(Project $project, Request $request): object
    {
        $data = json_decode($request->getContent());
        $task = (new ProjectTask)->setName(property_exists($data, 'name') ? $data->name : null);

        $violations = $this->filterViolations($this->validator->validate($task));

        if (count($violations) > 0) {

            return $this->sendViolations($violations);
        }

        $task->setRef($this->generateIdentifier('task'));
        $project->addTask($task);

        $this->manager->persist($project);
        $this->manager->flush();

        return $this->sendJson(
            $task,
            Response::HTTP_CREATED,
            [
                'Task-Link' => $this->router->generate('admin_project_task_edit', [
                    'id' => $task->getId(),
                ]),
            ]
        );
    }

    public function editTask(ProjectTask $task, Request $request): object
    {
        $task = $this->serializer->deserialize($request->getContent(), ProjectTask::class, 'json', ['object_to_populate' => $task]);
        $violations = $this->filterViolations($this->validator->validate($task));

        if (count($violations) > 0) {

            return $this->sendViolations($violations);
        }

        $this->manager->persist($task);
        $this->manager->flush();

        return $this->sendJson(
            $task,
            Response::HTTP_OK
        );
    }

    public function deleteTask(ProjectTask $task): object
    {
        $this->manager->remove($task);
        $this->manager->flush();

        return $this->sendNoContent();
    }

    /**
     * @param Project $project
     * @param Request $request
     *
     * @return object
     */
    public function createImage(Project $project, Request $request): object
    {
        $file = $request->files->get('image');
        $violations = [];

        if ($file instanceof UploadedFile) {
            $upload = $this->uploader->upload($file, $project);
            if ($upload instanceof ProjectImage) {
                $upload
                    ->setCreatedAt($this->now())
                    ->setRef('image')
                    ->setIsMain(count($project->getImages()) === 0)
                ;
                $project->addImage($upload);

                $this->manager->persist($project);
                $this->manager->flush();

                return $this->sendJson(
                    $upload,
                    Response::HTTP_CREATED,
                    [
                        'Project-Link' => $this->router->generate('admin_project_image_edit', [
                            'id' => $upload->getId() ?? 1,
                        ], UrlGenerator::ABSOLUTE_URL),
                    ]
                );
            }
            if (is_array($upload) && count($upload) > 0) {
                $violations = array_merge($violations, $upload);
                return $this->sendViolations($violations);
            }
        }

        return $this->sendViolations(['image' => 'Aucune image reçue']);
    }

    /**
     * @param ProjectImage $image
     *
     * @return object
     */
    public function editImage(ProjectImage $image, Request $request): object
    {
        $file = $request->files->get('image');
        $data = json_decode($request->getContent(), true);
        $violations = [];

        if ($file instanceof UploadedFile) {
            $upload = $this->uploader->upload($file, $image->getProject(), $image);

            if (is_array($upload) && count($upload) > 0) {
                $violations = array_merge($violations, $upload);
                return $this->sendViolations($violations);
            }
            if ($upload instanceof ProjectImage) {
                $image
                    ->setOriginalName($upload->getOriginalName())
                    ->setPath($upload->getPath())
                ;

            }
        }

        if (array_key_exists('is_main', $data)) {
            $image->setIsMain(true);
            $isMain = $this->imageRepository->findOneBy(['project' => $image->getProject(), 'is_main' => true]);
            if ($isMain instanceof ProjectImage) {
                $isMain->setIsMain(false);
                $this->manager->persist($isMain);
                $this->manager->flush();
            }
        }

        $image->setUpdatedAt($this->now());

        $this->manager->persist($image);
        $this->manager->flush();

        return $this->sendJson($image);
    }

    /**
     * @param ProjectImage $image
     *
     * @return object
     */
    public function deleteImage(ProjectImage $image): object
    {
        $this->uploader->remove($image);

        $this->manager->remove($image);
        $this->manager->flush();

        return $this->sendNoContent();
    }
}
