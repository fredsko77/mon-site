<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/project", name="project")
 */
class ProjectController extends AbstractController
{

    /**
     * @var ProjectRepository $repository
     */
    private $repository;

    public function __construct(ProjectRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route(
     *  "/{slug}-{id}",
     *  name="_show",
     *  methods={"GET"},
     *  requirements={
     *      "slug": "[a-z0-9\-]*",
     *      "id": "\d+"
     *  }
     * )
     */
    public function show(Request $request): Response
    {
        $project = $this->repository->find($request->attributes->get('id'));

        if ($project->getSlug() !== $request->attributes->get('slug')) {

            return $this->redirectToRoute(
                'project_show',
                [
                    'id' => $project->getId(),
                    'slug' => $project->getSlug(),
                ],
                Response::HTTP_FOUND
            );
        }

        return $this->render('site/project/show.html.twig', compact('project'));
    }
}
