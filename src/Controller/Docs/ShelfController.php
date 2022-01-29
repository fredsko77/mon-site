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
     * @Route("/nouveau", name="new", methods={"GET", "POST"})
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

}
