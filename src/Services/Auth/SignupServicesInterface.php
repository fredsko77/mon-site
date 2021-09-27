<?php
namespace App\Services\Auth;

use Symfony\Component\HttpFoundation\Request;

interface SignupServicesInterface
{

    /**
     * @param Request $request
     *
     * @return object
     */
    public function store(Request $request): object;

}
