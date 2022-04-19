<?php
namespace App\Services\Admin;

use App\Entity\Room;
use Symfony\Component\HttpFoundation\Request;

interface RoomServicesInterface
{

    /**
     * @return array
     */
    public function index(): array;

    /**
     * @param Room $room
     *
     * @return void
     */
    public function store(Room $room): void;

    /**
     * @param Room $room
     *
     * @return object
     */
    public function delete(Room $room): object;

    /**
     * @param Room $room
     * @param Request $request
     *
     * @return array
     */
    public function show(Room $room, Request $request): array;

}
