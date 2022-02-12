<?php
namespace App\Controller\Docs;

use App\Entity\Chapter;
use App\Form\Docs\ChapterCreateType;
use App\Services\Docs\ChapterServicesInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    public function __construct(ChapterServicesInterface $chapterService)
    {
        $this->chapterService = $chapterService;
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
        $form = $this->createForm(ChapterCreateType::class, $chapter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->chapterService->editChapter($chapter);

            return $this->redirectToRoute('docs_chapter_show', [
                'id' => $chapter->getId(),
                'slug' => $chapter->getSlug(),
            ]);
        }

        return $this->renderForm('docs/book/new_chapter.html.twig', compact('chapter', 'form'));
    }

}
