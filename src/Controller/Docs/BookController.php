<?php
namespace App\Controller\Docs;

use App\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("docs/livres", name="docs_book_")
 */
class BookController extends AbstractController
{

    public function __construct()
    {}

    /**
     * @Route(
     *  "/{slug}-{id}",
     *  name="show",
     *  methods={"GET", "POST"},
     *  requirements={
     *      "id": "\d+",
     *      "slug": "[a-z0-9\-]*"
     *  }
     * )
     */
    public function show(Book $book): Response
    {
        return $this->renderForm('docs/book/show.html.twig', compact('book'));
    }

}
