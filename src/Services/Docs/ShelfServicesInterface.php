<?php
namespace App\Services\Docs;

use App\Entity\Book;
use App\Entity\Shelf;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

interface ShelfServicesInterface
{

    /**
     * @param FormInterface $form
     * @param Request $request
     *
     * @return void
     */
    public function store(FormInterface $form, Shelf $shelf, Request $request): void;

    /**
     * @return Shelf[]|null
     */
    public function paginate(Request $request): PaginationInterface;

    /**
     * @param Shelf $shelf
     * @param Book $book
     *
     * @return void
     */
    public function newBook(Shelf $shelf, Book $book): void;

}
