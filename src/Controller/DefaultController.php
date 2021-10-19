<?php

namespace App\Controller;

use App\Services\DefaultServicesInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{

    /**
     * @var DefaultServicesInterface $service
     */
    private $service;

    public function __construct(DefaultServicesInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @Route("/", name="app_default")
     */
    public function index(): Response
    {
        return $this->render('default/index.html.twig', $this->service->index());
    }
}
