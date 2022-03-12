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
     * @param Book $book
     * @param null|Shelf $shelf
     *
     * @return void
     */
    public function newBook(Book $book, ?Shelf $shelf = null): void;

    /**
     * @param Book $book
     *
     * @return void
     */
    public function editBook(Book $book): void;

    /**
     * @param Shelf $shelf
     *
     * @return object
     */
    public function delete(Shelf $shelf): object;

    /**
     * @param Shelf $shelf
     *
     * @return array
     */
    public function show(Shelf $shelf, Request $request): array;

}
