<?php

namespace App\Controller\Dashboard;

use App\Entity\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard/content", name="dashboard_content")
 */
class ContentController extends AbstractController
{
    /**
     * @Route("", name="_form", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('dashboard/content/index.html.twig', [
            'content' => $this->getUser()->getContent() ?? (new Content()),
        ]);
    }
}
