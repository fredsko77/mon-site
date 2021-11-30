<?php
namespace App\Services\Auth;

use App\Entity\User;

interface SignupServicesInterface
{

    /**
     * @param User $user
     *
     * @return void
     */
    public function store(User $user): void;

}
