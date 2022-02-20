<?php
namespace App\Controller\Docs;

use App\Entity\Chapter;
use App\Entity\Page;
use App\Form\Docs\ChapterType;
use App\Form\Docs\PageType;
use App\Services\Docs\ChapterServicesInterface;
use App\Services\Docs\PageServicesInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/docs/chapitres", name="docs_chapter_")
 */
class ChapterController extends AbstractController
{

    /**
     * @var ChapterServicesInterface $chapterService
     */
    private $chapterService;

    /**
     * @var PageServicesInterface $pageService
     */
    private $pageService;

    public function __construct(ChapterServicesInterface $chapterService, PageServicesInterface $pageService)
    {
        $this->chapterService = $chapterService;
        $this->pageService = $pageService;
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
    public function show(Chapter $chapter): Response
    {
        $this->denyAccessUnlessGranted('chapter_view', $chapter);
        return $this->render('/docs/chapter/show.html.twig', compact('chapter'));
    }

    /**
     * @Route(
     *  "/action/{slug}-{id}/modifier",
     *  name="edit",
     *  methods={"GET", "POST"},
     *  requirements={
     *      "id": "\d+",
     *      "slug": "[a-z0-9\-]*"
     *  }
     * )
     */
    public function editChapter(Chapter $chapter, Request $request): Response
    {
        $this->denyAccessUnlessGranted('chapter_update', $chapter);
        $form = $this->createForm(ChapterType::class, $chapter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->chapterService->editChapter($chapter);

            return $this->redirectToRoute('docs_chapter_edit', [
                'id' => $chapter->getId(),
                'slug' => $chapter->getSlug(),
            ]);
        }

        return $this->renderForm('docs/chapter/new.html.twig', compact('chapter', 'form'));
    }

    /**
     * @Route(
     *  "/action/{slug}-{id}/nouvelle-page",
     *  name="new_page",
     *  methods={"GET", "POST"},
     *  requirements={
     *      "id": "\d+",
     *      "slug": "[a-z0-9\-]*"
     *  }
     * )
     */
    public function createPage(Chapter $chapter, Request $request): Response
    {
        $this->denyAccessUnlessGranted('page_create', $chapter);
        $page = new Page;
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->pageService->createPage($page, $chapter);

            return $this->redirectToRoute('docs_chapter_edit', [
                'id' => $chapter->getId(),
                'slug' => $chapter->getSlug(),
            ]);
        }

        return $this->renderForm('docs/page/new.html.twig', compact('chapter', 'form'));
    }

    /**
     * @Route(
     *  "/action/{slug}-{id}/supprimer",
     *  name="delete",
     *  requirements={
     *      "id": "\d+",
     *      "slug": "[a-z0-9\-]*"
     *  },
     *  methods={"DELETE"}
     * )
     */
    public function delete(Chapter $chapter): JsonResponse
    {
        $this->denyAccessUnlessGranted('chapter_delete', $chapter);
        $response = $this->chapterService->delete($chapter);

        return $this->json(
            $response->data,
            $response->status,
            $response->headers
        );
    }

}
