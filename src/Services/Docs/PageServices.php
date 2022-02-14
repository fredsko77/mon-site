<?php
namespace App\Services\Docs;

use App\Entity\Page;
use App\Repository\PageRepository;
use App\Services\Docs\PageServicesInterface;
use App\Utils\ServicesTrait;
use Cocur\Slugify\Slugify;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PageServices implements PageServicesInterface
{

    use ServicesTrait;

    /**
     * @var EntityManagerInterface $manager
     */
    private $manager;

    /**
     * @var Slugify $slugger
     */
    private $slugger;

    /**
     * @var ChapterRepository $repository
     */
    private $repository;

    /**
     * @var UrlGeneratorInterface $router
     */
    private $router;

    public function __construct(
        EntityManagerInterface $manager,
        PageRepository $repository,
        UrlGeneratorInterface $router
    ) {
        $this->manager = $manager;
        $this->repository = $repository;
        $this->router = $router;
        $this->slugger = new Slugify;
    }

    /**
     * @param Page $page
     * @param object $instance
     *
     * @return void
     */
    public function createPage(Page $page, object $instance): void
    {
        $page->getId() !== null ? $page->setUpdatedAt(new DateTime) : $page->setCreatedAt(new DateTime);

        $page->setSlug(
            $this->slugger->slugify(
                $page->getSlug() ?? $page->getTitle(),
                '-'
            )
        );

        $instance->addPage($page);

        $this->manager->persist($instance);
        $this->manager->flush();

    }

    /**
     * @param Page $page
     *
     * @return object
     */
    public function delete(Page $page): object
    {
        $location = '';
        if ($page->getBook()) {
            $location = $this->router->generate('docs_book_show', [
                'id' => $page->getBook()->getId(),
                'slug' => $page->getBook()->getSlug(),
            ]);
        } else {
            $location = $this->router->generate('docs_chapter_show', [
                'id' => $page->getChapter()->getId(),
                'slug' => $page->getChapter()->getSlug(),
            ]);
        }

        $this->manager->remove($page);
        $this->manager->flush();

        return $this->sendNoContent([
            'Location' => $location,
        ]);
    }
}
