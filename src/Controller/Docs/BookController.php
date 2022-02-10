<?php
namespace App\Controller\Docs;

use App\Entity\Book;
use App\Entity\Chapter;
use App\Entity\Page;
use App\Form\Docs\ChapterCreateType;
use App\Form\Docs\PageCreateType;
use App\Services\Docs\ChapterServicesInterface;
use App\Services\Docs\PageServicesInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("docs/livres", name="docs_book_")
 */
class BookController extends AbstractController
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
     *  methods={"GET"},
     *  requirements={
     *      "id": "\d+",
     *      "slug": "[a-z0-9\-]*"
     *  }
     * )
     */
    public function show(Book $book): Response
    {
        return $this->render('docs/book/show.html.twig', compact('book'));
    }

    /**
     * @Route(
     *  "/action/{slug}-{id}/nouveau-chapitre",
     *  name="new_chapter",
     *  methods={"GET", "POST"},
     *  requirements={
     *      "id": "\d+",
     *      "slug": "[a-z0-9\-]*"
     *  }
     * )
     */
    public function createChapter(Book $book, Request $request): Response
    {
        $chapter = new Chapter;
        $form = $this->createForm(ChapterCreateType::class, $chapter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->chapterService->createChapter($chapter, $book);

            return $this->redirectToRoute('docs_book_show', [
                'id' => $book->getId(),
                'slug' => $book->getSlug(),
            ]);
        }

        return $this->renderForm('docs/book/new_chapter.html.twig', compact('book', 'form'));
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
    public function createPage(Book $book, Request $request): Response
    {
        $page = new Page;
        $form = $this->createForm(PageCreateType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->pageService->createPage($page, $book);

            return $this->redirectToRoute('docs_book_show', [
                'id' => $book->getId(),
                'slug' => $book->getSlug(),
            ]);
        }

        return $this->renderForm('docs/book/new_page.html.twig', compact('book', 'form'));
    }
}
