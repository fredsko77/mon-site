<?php
namespace App\Services\Docs;

use App\Entity\Book;

interface BookServicesInterface
{

    /**
     * @param Book $book
     *
     * @return object
     */
    public function delete(Book $book): object;

    /**
     * @param Book $book
     * 
     * @return array
     * 
     */
    public function show(Book $book):array;


}
