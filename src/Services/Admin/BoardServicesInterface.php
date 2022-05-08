<?php
namespace App\Services\Admin;

use App\Entity\Board;
use App\Entity\Room;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

interface BoardServicesInterface
{

    /**
     * @param FormInterface $form
     * @param Board $board
     * @param Room $room
     *
     * @return void
     */
    public function create(FormInterface $form, Board $board, Room $room): void;

    /**
     * @param Board $board
     *
     * @return void
     */
    public function store(Board $board): void;

    /**
     * @param Board $board
     *
     * @return object
     */
    public function delete(Board $board): object;

    /**
     * @param Board $board
     *
     * @return object
     */
    public function toggle(Board $board): object;

    /**
     * @param Board $board
     * @param Request $request
     *
     * @return object
     */
    public function apiEdit(Board $board, Request $request): object;

    /**
     * @param Board $board
     *
     * @return object
     */
    public function apiDelete(Board $board): object;

    /**
     * @param Board $board
     * @param Request $request
     *
     * @return array
     */
    public function filter(Board $board, Request $request): array;

    /**
     * @param Board $board
     *
     * @return object
     */
    public function bookmark(Board $board): object;

}
