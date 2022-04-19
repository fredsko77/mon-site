<?php
namespace App\Services\Admin;

use App\Entity\Room;
use App\Repository\BoardRepository;
use App\Repository\RoomRepository;
use App\Services\Admin\RoomServicesInterface;
use App\Utils\ServicesTrait;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

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

    /**
     * @var PaginatorInterface $paginator
     */
    private $paginator;

    /**
     * @var BoardRepository $boardRepository
     */
    private $boardRepository;

    public function __construct(
        RoomRepository $repository,
        EntityManagerInterface $manager,
        PaginatorInterface $paginator,
        BoardRepository $boardRepository
    ) {
        $this->repository = $repository;
        $this->manager = $manager;
        $this->paginator = $paginator;
        $this->boardRepository = $boardRepository;
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

    /**
     * @param Room $room
     * @param Request $request
     *
     * @return array
     */
    public function show(Room $room, Request $request): array
    {
        // Get data from $_GET
        $state = $request->query->getBoolean('isOpen', true);
        $sort = $request->query->get('sort', null);
        $page = $request->query->getInt('page', 1);
        $nbItems = $request->query->getInt('nbItems', 5);

        // Get data from Database|Repository
        $data = $this->getData($this->boardRepository->findRoomFilteredBoards(
            $room,
            $state,
            $sort
        ));

        // Get boards for pagination
        $boards = $this->paginator->paginate(
            $data,
            $page,
            $nbItems
        );

        return compact('room', 'boards');
    }

    private function getData(array $array): array
    {
        $data = [];
        foreach ($array as $key => $item) {
            if (is_array($item)) {
                $data[$key] = $item[0];
            } else {
                return $array;
            }
        }

        return $data;
    }

}
