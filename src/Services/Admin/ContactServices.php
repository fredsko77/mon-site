<?php
namespace App\Services\Admin;

use App\Repository\ContactRepository;

class ContactServices implements ContactServicesInterface
{

    /**
     * @var ContactRepository $repository
     */
    private $repository;

    public function __construct(ContactRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(): ?array
    {
        return $this->repository->findAll();
    }

}
