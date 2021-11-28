<?php
namespace App\Services\Admin;

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
