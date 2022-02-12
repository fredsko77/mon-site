<?php
namespace App\Controller\Docs;

use App\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/docs/pages", name="docs_page_")
 */
class PageController extends AbstractController
{

    public function __construct()
    {}

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

}
