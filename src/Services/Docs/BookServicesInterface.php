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

}
