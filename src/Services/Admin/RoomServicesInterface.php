<?php
namespace App\Services\Admin;

use App\Entity\Room;

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

}
