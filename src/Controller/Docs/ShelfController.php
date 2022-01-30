<?php
namespace App\Controller\Docs;

use App\Entity\Shelf;
use App\Form\Docs\ShelfType;
use App\Services\Docs\ShelfServicesInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    public function __construct(ShelfServicesInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @Route("", name="index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('docs/shelf/index.html.twig');
    }

    /**
     * @Route(
     *  "/nouveau",
     *  name="new",
     *  methods={"GET", "POST"}
     * )
     */
    public function create(Request $request): Response
    {
        $shelf = new Shelf;
        $form = $this->createForm(ShelfType::class, $shelf);
        $form->handleRequest($request);

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
     *  "/{id}/edit",
     *  name="edit",
     *  methods={"GET", "POST"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function edit(Shelf $shelf, Request $request): Response
    {
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

}
