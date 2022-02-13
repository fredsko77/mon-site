<?php
namespace App\Services\Docs;

use App\Entity\Book;
use App\Services\Docs\BookServicesInterface;
use App\Utils\ServicesTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class BookServices implements BookServicesInterface
{

    use ServicesTrait;

    /**
     * @var EntityManagerInterface $manager
     */
    private $manager;

    /**
     * @var UrlGeneratorInterface $router
     */
    private $router;

    public function __construct(EntityManagerInterface $manager, UrlGeneratorInterface $router)
    {
        $this->manager = $manager;
        $this->router = $router;
    }

    /**
     * @param Book $book
     *
     * @return object
     */
    public function delete(Book $book): object
    {
        $location = $this->router->generate('docs_shelf_show', [
            'id' => $book->getShelf()->getId(),
            'slug' => $book->getShelf()->getSlug(),
        ]);

        $this->manager->remove($book);
        $this->manager->flush();

        return $this->sendNoContent([
            'Location' => $location,
        ]);
    }

}
