<?php
namespace App\Services\Admin;

use App\Entity\Room;
use App\Repository\RoomRepository;
use App\Services\Admin\RoomServicesInterface;
use App\Utils\ServicesTrait;
use Doctrine\ORM\EntityManagerInterface;

class RoomServices implements RoomServicesInterface
{

    use ServicesTrait;

    /**
     * @var EntityManagerInterface $manager
     */
    private $manager;

    /**
     * @var RoomRepository $repository
     */
    private $repository;

    public function __construct(RoomRepository $repository, EntityManagerInterface $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
    }

    /**
     * @return array
     */
    public function index(): array
    {
        $rooms = $this->repository->findAll();

        return compact('rooms');
    }

    /**
     * @param Room $room
     *
     * @return void
     */
    public function store(Room $room): void
    {
        $room->getId() !== null ? $room->setUpdatedAt($this->now()) : $room->setCreatedAt($this->now());

        $this->manager->persist($room);
        $this->manager->flush();
    }

    /**
     * @param Room $room
     *
     * @return object
     */
    public function delete(Room $room): object
    {
        $this->manager->remove($room);
        $this->manager->flush();

        return $this->sendNoContent();
    }

}
