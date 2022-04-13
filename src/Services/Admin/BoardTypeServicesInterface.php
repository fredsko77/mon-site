<?php
namespace App\Services\Admin;

use App\Entity\BoardType;

interface BoardTypeServicesInterface
{

    /**
     * @return array
     */
    public function index(): array;

    /**
     * @param BoardType $boardType
     *
     * @return void
     */
    public function store(BoardType $boardType): void;

    /**
     * @param BoardType $boardType
     *
     * @return object
     */
    public function delete(BoardType $boardType): object;

}
