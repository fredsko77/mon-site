<?php
namespace App\Controller\Website;

use App\Repository\ProjectRepository;
use App\Services\WebSiteServicesInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mes-realisations", name="website_project_")
 */
class ProjectController extends AbstractController
{

    /**
     * @var WebSiteServicesInterface $service
     */
    private $service;

    /**
     * @var ProjectRepository $repository
     */
    private $repository;

    public function __construct(WebSiteServicesInterface $service, ProjectRepository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }

    /**
     * @Route(
     *  "",
     *  name="index",
     *  methods={"GET"}
     * )
     */
    public function index(Request $request): Response
    {
        return $this->render('site/project/index.html.twig', [
            'projects' => $this->service->paginatedProjects($request),
        ]);
    }

    /**
     * @Route(
     *  "/{slug}-{id}",
     *  name="show",
     *  requirements={
     *      "id": "\d+",
     *      "slug": "[a-z0-9\-]*"
     *  },
     *  methods={"GET"}
     * )
     */
    public function show(int $id, string $slug): Response
    {

        $project = $this->repository->find((int) $id);

        if ($project === null) {

            return $this->redirectToRoute('website_project_index');
        }

        if ($slug !== $project->getSlug()) {

            return $this->redirectToRoute(
                'website_project_show',
                [
                    'slug' => $project->getSlug(),
                    'id' => $project->getId(),
                ],
                Response::HTTP_FOUND
            );
        }

        $this->denyAccessUnlessGranted('project_view', $project);

        return $this->render('site/project/show.html.twig', [
            'project' => $project,
        ]);
    }

}
