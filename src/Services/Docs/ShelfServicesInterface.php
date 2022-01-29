<?php
namespace App\Services\Docs;

use App\Entity\Shelf;
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

}
