<?php

namespace App\Controller\Dashboard;

use App\Entity\Content;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/{id}/edit", name="_edit", methods={"PUT"})
     */
    public function edit(Request $request): JsonResponse
    {
        return $this->json([]);
    }

    /**
     * @Route("", name="_store", methods={"POST"})
     */
    public function store(Request $request): JsonResponse
    {
        return $this->json([]);
    }
}
