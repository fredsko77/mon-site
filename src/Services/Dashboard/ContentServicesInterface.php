<?php
namespace App\Services\Dashboard;

use Symfony\Component\HttpFoundation\Request;

interface ContentServicesInterface
{

    /**
     * @param Request $request
     *
     * @return object
     */
    public function store(Request $request): object;

}
