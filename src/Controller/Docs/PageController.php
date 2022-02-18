<?php
namespace App\Controller\Docs;

use App\Entity\Page;
use App\Form\Docs\PageType;
use App\Services\Docs\PageServicesInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/docs/pages", name="docs_page_")
 */
class PageController extends AbstractController
{
    /**
     * @var PageServicesInterface $service
     */

    public function __construct(PageServicesInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @Route(
     *  "/{slug}-{id}",
     *  name="show",
     *  requirements={
     *      "id": "\d+",
     *      "slug": "[a-z0-9\-]*"
     *  },
     *  methods={"GET"}
     * )
     */
    public function show(Page $page): Response
    {
        return $this->render('/docs/page/show.html.twig', compact('page'));
    }

    /**
     * @Route(
     *  "/action/{slug}-{id}/supprimer",
     *  name="delete",
     *  requirements={
     *      "id": "\d+",
     *      "slug": "[a-z0-9\-]*"
     *  },
     *  methods={"DELETE"}
     * )
     */
    public function delete(Page $page): Response
    {
        $response = $this->service->delete($page);

        return $this->json(
            $response->data,
            $response->status,
            $response->headers
        );
    }

    /**
     * @Route(
     *  "/action/{slug}-{id}/modifier",
     *  name="edit",
     *  requirements={
     *      "id": "\d+",
     *      "slug": "[a-z0-9\-]*"
     *  },
     *  methods={"GET", "POST"}
     * )
     */
    public function edit(Page $page, Request $request): Response
    {
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->service->edit($page);

            return $this->redirectToRoute('docs_page_show', [
                'id' => $page->getId(),
                'slug' => $page->getSlug(),
            ]);
        }

        return $this->renderForm('docs/page/edit.html.twig', compact('page', 'form'));
    }

}
