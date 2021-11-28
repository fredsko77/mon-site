<?php

namespace App\Controller\Docs;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/docs", name="docs_")
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("", name="default")
     */
    public function index(): Response
    {
        return $this->render('docs/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}
