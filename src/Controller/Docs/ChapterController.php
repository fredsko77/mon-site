<?php
namespace App\Controller\Docs;

use App\Entity\Chapter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/docs/chapitres", name="docs_chapter_")
 */
class ChapterController extends AbstractController
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
    public function show(Chapter $chapter): Response
    {
        return $this->render('/docs/chapter/show.html.twig', compact('chapter'));
    }

}
