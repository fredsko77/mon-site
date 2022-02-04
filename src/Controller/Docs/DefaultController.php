<?php

namespace App\Controller\Docs;

use App\Services\Docs\ShelfServicesInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
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
     * @Route("/docs", name="docs_default", methods={"GET"})
     * @Route("/docs", name="docs_shelf_index", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        return $this->render('docs/shelf/index.html.twig', [
            'shelves' => $this->service->paginate($request),
        ]);
    }

}
