<?php
namespace App\Services\Auth;

use App\Entity\User;

interface AuthServicesInterface
{

    /**
     * @param User $user
     *
     * @return void
     */
    public function store(User $user): void;

    /**
     * @param null|array $data
     *
     * @return void
     */
    public function forgotPassword(?array $data = null): void;

}
