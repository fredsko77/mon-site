<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use App\Form\Admin\ProjectType;
use App\Services\Admin\ProjectServicesInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/project", name="admin_project_")
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
     *  name="list",
     *  methods={"GET"}
     * )
     */
    public function index(): Response
    {
        return $this->render('admin/project/index.html.twig', $this->service->listProjects());
    }

    /**
     * @Route(
     *  "/new",
     *  name="new",
     *  methods={"POST", "GET"}
     * )
     */
    public function create(Request $request): Response
    {
        $project = new Project;
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->service->store($form, $project);

            return $this->redirectToRoute('admin_project_edit', [
                'id' => $project->getId(),
            ]);
        }

        return $this->renderForm('admin/project/new.html.twig', [
            'form' => $form,
            'project' => $project,
        ]);
    }

    /**
     * @Route(
     *  "/{id}/edit",
     *  name="edit",
     *  methods={"GET", "POST"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function edit(Request $request, Project $project): Response
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->service->store($form, $project);

            return $this->redirectToRoute('admin_project_edit', [
                'id' => $project->getId(),
            ]);
        }

        return $this->renderForm("admin/project/edit.html.twig", [
            'form' => $form,
            'project' => $project,
        ]);
    }

    /**
     * @Route(
     *  "/{id}",
     *  name="delete",
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

}
