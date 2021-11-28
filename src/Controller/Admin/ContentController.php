<?php

namespace App\Controller\Admin;

use App\Entity\Content;
use App\Services\Admin\ContentServicesInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/content", name="admin_content")
 */
class ContentController extends AbstractController
{

    /**
     * @var ContentServicesInterface $service
     */
    private $service;

    public function __construct(ContentServicesInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @Route("", name="_form", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin/content/index.html.twig', [
            'content' => $this->getUser()->getContent() ?? (new Content()),
        ]);
    }

    /**
     * @Route("", name="_store", methods={"POST"})
     */
    public function store(Request $request): JsonResponse
    {
        $response = $this->service->store($request);
        return $this->json(
            $response->data,
            $response->status,
            $response->headers,
            ['groups' => 'content:read']
        );
    }
}
