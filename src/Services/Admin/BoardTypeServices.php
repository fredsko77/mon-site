<?php
namespace App\Services\Admin;

use App\Entity\BoardType;
use App\Repository\BoardTypeRepository;
use App\Services\Admin\BoardTypeServicesInterface;
use App\Utils\ServicesTrait;
use Doctrine\ORM\EntityManagerInterface;

class BoardTypeServices implements BoardTypeServicesInterface
{

    use ServicesTrait;

    /**
     * @var EntityManagerInterface $manager
     */
    private $manager;

    /**
     * @var BoardTypeRepository $repository
     */
    private $repository;

    public function __construct(BoardTypeRepository $repository, EntityManagerInterface $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    /**
     * @return array
     */
    public function index(): array
    {
        $boardTypes = $this->repository->findAll();

        return compact('boardTypes');
    }

    /**
     * @param BoardType $boardType
     *
     * @return void
     */
    public function store(BoardType $boardType): void
    {
        $boardType->getId() !== null ? $boardType->setUpdatedAt($this->now()) : $boardType->setCreatedAt($this->now());

        $this->manager->persist($boardType);
        $this->manager->flush();
    }

}
