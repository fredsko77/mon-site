<?php
namespace App\Services\Docs;

use App\Entity\Chapter;
use App\Repository\ChapterRepository;
use App\Services\Docs\ChapterServicesInterface;
use Cocur\Slugify\Slugify;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class ChapterServices implements ChapterServicesInterface
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
        ChapterRepository $repository
    ) {
        $this->manager = $manager;
        $this->repository = $repository;
        $this->slugger = new Slugify;
    }

    public function createChapter(Chapter $chapter, object $instance): void
    {
        $chapter->getId() !== null ? $chapter->setUpdatedAt(new DateTime) : $chapter->setCreatedAt(new DateTime);

        $chapter->setSlug(
            $this->slugger->slugify(
                $chapter->getSlug() ?? $chapter->getTitle(),
                '-'
            )
        );

        $instance->addChapter($chapter);

        $this->manager->persist($instance);
        $this->manager->flush();
    }

}
