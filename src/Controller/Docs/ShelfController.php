<?php
namespace App\Controller\Docs;

use App\Entity\Book;
use App\Entity\Shelf;
use App\Form\Docs\BookType;
use App\Form\Docs\ShelfType;
use App\Repository\ShelfRepository;
use App\Services\Docs\ShelfServicesInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/docs/etageres", name="docs_shelf_")
 */
class ShelfController extends AbstractController
{

    /**
     * @var ShelfServicesInterface $service
     */
    private $service;

    /**
     * @var ShelfRepository $repository
     */
    private $repository;

    public function __construct(ShelfServicesInterface $service, ShelfRepository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }

    /**
     * @Route(
     *  "/action/nouveau",
     *  name="new",
     *  methods={"GET", "POST"}
     * )
     */
    public function create(Request $request): Response
    {
        $shelf = new Shelf;
        $form = $this->createForm(ShelfType::class, $shelf);
        $form->handleRequest($request);

        $this->denyAccessUnlessGranted('shelf_create', $shelf);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->service->store($form, $shelf, $request);

            return $this->redirectToRoute('docs_shelf_index');
        }

        return $this->renderForm('docs/shelf/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route(
     *  "/action/{id}/edit",
     *  name="edit",
     *  methods={"GET", "POST"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function edit(Shelf $shelf, Request $request): Response
    {
        $this->denyAccessUnlessGranted('shelf_edit', $shelf);

        $form = $this->createForm(ShelfType::class, $shelf);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->service->store($form, $shelf, $request);

            return $this->redirectToRoute('docs_shelf_edit', [
                'id' => $shelf->getId(),
            ]);
        }

        return $this->renderForm('docs/shelf/edit.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route(
     *  "/action/{slug}-{id}/nouveau-livre",
     *  name="new_book",
     *  requirements={
     *      "id": "\d+",
     *      "slug": "[a-z0-9\-]*"
     *  },
     *  methods={"GET", "POST"}
     * )
     */
    public function createBook(Shelf $shelf, Request $request): Response
    {
        $book = new Book;
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        $this->denyAccessUnlessGranted('book_create', $book);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->service->newBook($book, $shelf);

            return $this->redirectToRoute('docs_shelf_show', [
                'id' => $shelf->getId(),
                'slug' => $shelf->getSlug(),
            ]);
        }

        return $this->renderForm('docs/book/new.html.twig', compact('shelf', 'form'));
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
        $shelf = $this->repository->find((int) $id);
        $user = $this->getUser();

        if ($shelf === null) {

            return $this->redirectToRoute('docs_shelf_index');
        }

        $this->denyAccessUnlessGranted('shelf_view', $shelf);

        if ($slug !== $shelf->getSlug()) {

            return $this->redirectToRoute(
                'website_shelf_show',
                [
                    'slug' => $shelf->getSlug(),
                    'id' => $shelf->getId(),
                ],
                Response::HTTP_FOUND
            );
        }

        return $this->render('docs/shelf/show.html.twig', ['shelf' => $shelf]);
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
    public function delete(Shelf $shelf): JsonResponse
    {
        $this->denyAccessUnlessGranted('shelf_delete', $shelf);

        $response = $this->service->delete($shelf);

        return $this->json(
            $response->data,
            $response->status,
            $response->headers
        );
    }

}
