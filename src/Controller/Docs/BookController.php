<?php
namespace App\Controller\Docs;

use App\Entity\Book;
use App\Entity\Chapter;
use App\Entity\Page;
use App\Form\Docs\BookType;
use App\Form\Docs\ChapterType;
use App\Form\Docs\PageType;
use App\Services\Docs\BookServicesInterface;
use App\Services\Docs\ChapterServicesInterface;
use App\Services\Docs\PageServicesInterface;
use App\Services\Docs\ShelfServicesInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    /**
     * @var ShelfServicesInterface $shelfService
     */
    private $shelfService;

    /**
     * @var BookServicesInterface $bookService
     */
    private $bookService;

    public function __construct(ChapterServicesInterface $chapterService, PageServicesInterface $pageService, ShelfServicesInterface $shelfService, BookServicesInterface $bookService)
    {
        $this->chapterService = $chapterService;
        $this->pageService = $pageService;
        $this->shelfService = $shelfService;
        $this->bookService = $bookService;
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
        $this->denyAccessUnlessGranted('book_view', $book);
        return $this->render('docs/book/show.html.twig', compact('book'));
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
    public function editBook(Book $book, Request $request): Response
    {
        $this->denyAccessUnlessGranted('book_update', $book);

        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->shelfService->editBook($book);

            return $this->redirectToRoute('docs_book_show', [
                'id' => $book->getShelf()->getId(),
                'slug' => $book->getShelf()->getSlug(),
            ]);
        }

        return $this->renderForm('docs/book/new.html.twig', compact('form', 'book'));
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
        $form = $this->createForm(ChapterType::class, $chapter);
        $form->handleRequest($request);
        $this->denyAccessUnlessGranted('chapter_create', $chapter);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->chapterService->createChapter($chapter, $book);

            return $this->redirectToRoute('docs_book_show', [
                'id' => $book->getId(),
                'slug' => $book->getSlug(),
            ]);
        }

        return $this->renderForm('docs/chapter/new.html.twig', compact('book', 'form'));
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
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);
        $this->denyAccessUnlessGranted('page_create', $page);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->pageService->createPage($page, $book);

            return $this->redirectToRoute('docs_book_show', [
                'id' => $book->getId(),
                'slug' => $book->getSlug(),
            ]);
        }

        return $this->renderForm('docs/page/new.html.twig', compact('book', 'form'));
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
    public function delete(Book $book): JsonResponse
    {
        $this->denyAccessUnlessGranted('book_delete', $book);
        $response = $this->bookService->delete($book);

        return $this->json(
            $response->data,
            $response->status,
            $response->headers
        );
    }

}
