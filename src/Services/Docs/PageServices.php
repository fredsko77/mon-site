<?php
namespace App\Services\Docs;

use App\Entity\Page;
use App\Repository\PageRepository;
use App\Services\Docs\PageServicesInterface;
use Cocur\Slugify\Slugify;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class PageServices implements PageServicesInterface
{

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

    public function __construct(
        EntityManagerInterface $manager,
        PageRepository $repository
    ) {
        $this->manager = $manager;
        $this->repository = $repository;
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
}
