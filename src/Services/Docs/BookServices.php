<?php
namespace App\Services\Docs;

use App\Entity\Book;
use App\Repository\BookRepository;
use App\Repository\ChapterRepository;
use App\Repository\PageRepository;
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

    /**
     * @var BookRepository $repository
     */
    private $repository;

    /**
     * @var ChapterRepository $chapterRepository
     */
    private $chapterRepository;

    /**
     * @var PageRepository $pageRepository
     */
    private $pageRepository;

    public function __construct(
        EntityManagerInterface $manager, 
        UrlGeneratorInterface $router,
        BookRepository $repository,
        ChapterRepository $chapterRepository,
        PageRepository $pageRepository
    ) {
        $this->manager = $manager;
        $this->router = $router;
        $this->repository = $repository;
        $this->chapterRepository = $chapterRepository;
        $this->pageRepository = $pageRepository;
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

    /**
     * @param Book $book
     * 
     * @return array
     * 
     */
    public function show(Book $book): array
    {
        $chapters = $this->chapterRepository->findBookChapters(['book' => $book]);
        $pages = $this->pageRepository->findBookPages(['book' => $book]);

        return compact('book', 'chapters', 'pages');
    }

}
