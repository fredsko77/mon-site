<?php

namespace App\Controller\Dashboard;

use App\Entity\Project;
use App\Entity\ProjectImage;
use App\Entity\ProjectTask;
use App\Services\Dashboard\ProjectServicesInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard/project", name="dashboard_project")
 */
class ProjectController extends AbstractController
{

    /**
     * @var ProjectServicesInterface $service
     */
    private $service;

    public function __construct(ProjectServicesInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @Route(
     *  "",
     *  name="_list",
     *  methods={"GET"}
     * )
     */
    public function index(): Response
    {
        return $this->render('dashboard/project/index.html.twig', $this->service->listProjects());
    }

    /**
     * @Route(
     *  "/{id}/edit",
     *  name="_edit",
     *  methods={"GET"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function edit(Project $project): Response
    {
        return $this->render("dashboard/project/edit.html.twig", [
            'project' => $project,
        ]);
    }

    /**
     * @Route(
     *  "/{id}",
     *  name="_delete",
     *  methods={"DELETE"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function delete(Project $project): JsonResponse
    {
        $response = $this->service->delete($project);

        return $this->json(
            $response->data,
            $response->status,
            $response->headers
        );
    }

    /**
     * @Route(
     *  "/{id}/edit",
     *  name="_store",
     *  methods={"PUT"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function store(Request $request, Project $project): JsonResponse
    {
        $response = $this->service->store($request, $project);

        return $this->json(
            $response->data,
            $response->status,
            $response->headers,
            ['groups' => 'project:read']
        );
    }

    /**
     * @Route(
     *  "",
     *  name="_new",
     *  methods={"POST"}
     * )
     */
    public function create(Request $request)
    {
        $response = $this->service->create($request);

        return $this->json(
            $response->data,
            $response->status,
            $response->headers,
            ['groups' => 'project:read']
        );
    }

    /**
     * @Route(
     *  "/{id}/task",
     *  name="_task_new",
     *  methods={"POST"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function createTask(Project $project, Request $request): JsonResponse
    {
        $response = $this->service->createTask($project, $request);

        return $this->json(
            $response->data,
            $response->status,
            $response->headers,
            ['groups' => 'task:read']
        );
    }

    /**
     * @Route(
     *  "/{id}/task",
     *  name="_task_edit",
     *  methods={"PUT"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function editTask(ProjectTask $task, Request $request): JsonResponse
    {
        $response = $this->service->editTask($task, $request);

        return $this->json(
            $response->data,
            $response->status,
            $response->headers,
            ['groups' => 'task:read']
        );
    }

    /**
     * @Route(
     *  "/{id}/task",
     *  name="_task_delete",
     *  methods={"DELETE"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function deleteTask(ProjectTask $task): JsonResponse
    {
        $response = $this->service->deleteTask($task);

        return $this->json(
            $response->data,
            $response->status,
            $response->headers
        );
    }

    /**
     * @Route(
     *  "/{id}/image",
     *  name="_image_new",
     *  methods={"POST"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function createImage(Project $project, Request $request): JsonResponse
    {
        $response = $this->service->createImage($project, $request);

        return $this->json(
            $response->data,
            $response->status,
            $response->headers,
            ['groups' => 'image:read']
        );
    }

    /**
     * @Route(
     *  "/{id}/image/edit",
     *  name="_image_edit",
     *  methods={"POST"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function editImage(ProjectImage $image, Request $request): JsonResponse
    {
        $response = $this->service->editImage($image, $request);

        return $this->json(
            $response->data,
            $response->status,
            $response->headers,
            ['groups' => 'image:read']
        );
    }

    /**
     * @Route(
     *  "/{id}/image",
     *  name="_image_delete",
     *  methods={"DELETE"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function deleteImage(ProjectImage $project): JsonResponse
    {
        $response = $this->service->deleteImage($project);

        return $this->json(
            $response->data,
            $response->status,
            $response->headers,
            ['groups' => 'image:read']
        );
    }

}
