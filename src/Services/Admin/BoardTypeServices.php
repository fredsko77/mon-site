<?php
namespace App\Services\Admin;

use App\Entity\BoardType;
use App\Repository\BoardTypeRepository;
use App\Services\Admin\BoardTypeServicesInterface;

class BoardTypeServices implements BoardTypeServicesInterface
{

    /**
     * @var EntityManagerInterface $manager
     */
    private $manager;

    /**
     * @var BoardTypeRepository $repository
     */
    private $repository;

    public function __construct(BoardTypeRepository $repository)
    {
        $this->repository = $repository;
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
    }

}
