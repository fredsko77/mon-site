<?php
namespace App\Services;

use App\Entity\Contact;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\HttpFoundation\Request;

interface WebSiteServicesInterface
{

    /**
     * @return array
     */
    public function index(): array;

    /**
     * @param Contact $contact
     *
     * @return void
     */
    public function contact(Contact $contact): void;

    /**
     * @param Request $request
     *
     * @return PaginationInterface
     */
    public function paginatedProjects(Request $request): PaginationInterface;

}
