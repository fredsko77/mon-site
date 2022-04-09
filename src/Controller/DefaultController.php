<?php

namespace App\Controller;

use App\Services\WebSiteServicesInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{

    /**
     * @var WebSiteServicesInterface $service
     */
    private $service;

    public function __construct(WebSiteServicesInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @Route("/", name="app_default", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('site/home-page.html.twig', $this->service->index());
    }
}
