<?php
namespace App\Services\Admin;

use App\Entity\Board;
use App\Entity\BoardTag;
use Symfony\Component\HttpFoundation\Request;

interface BoardTagServicesInterface
{

    /**
     * @param BoardTag $tag
     *
     * @return object
     */
    public function edit(BoardTag $tag, Request $request): object;

    /**
     * @param Board $board
     * @param Request $request
     *
     * @return object
     */
    public function create(Board $board, Request $request): object;

    /**
     * @param BoardTag $tag
     *
     * @return object
     */
    public function delete(BoardTag $tag): object;

    /**
     * @var Board $board
     *
     * @return object
     */
    public function listTags(Board $board): object;

    /**
     * @param BoardTag $tag
     *
     * @return object
     */
    public function show(BoardTag $tag): object;

}
