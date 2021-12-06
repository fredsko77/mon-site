<?php

namespace App\Controller\Admin;

use App\Entity\Content;
use App\Form\Admin\ContentType;
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
     * @Route("", name="_list", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin/content/index.html.twig', [
            'contents' => $this->service->all(),
        ]);
    }

    /**
     * @Route(
     *  "/{id}",
     *  name="_edit",
     *  methods={"GET", "POST"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function edit(Content $content, Request $request): Response
    {

        $form = $this->createForm(ContentType::class, $content);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->service->store($form, $content);
            $this->addFlash(
                'info',
                'Le contenu a été mis à jour'
            );

            return $this->redirectToRoute('admin_content_edit', [
                'id' => $content->getId(),
            ]);
        }

        return $this->renderForm('admin/content/edit.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/create", name="_create", methods={"GET", "POST"})
     */
    public function create(Request $request): Response
    {
        $content = new Content;
        $form = $this->createForm(ContentType::class, $content);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->service->store($form, $content);

            return $this->redirectToRoute('admin_content_edit', [
                'id' => $content->getId(),
            ]);
        }

        return $this->renderForm('admin/content/create.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route(
     *  "/{id}",
     *  name="_delete",
     *  methods={"DELETE"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function delete(Content $content): JsonResponse
    {
        $response = $this->service->delete($content);

        return $this->json(
            $response->data,
            $response->status,
            $response->headers
        );
    }
}
