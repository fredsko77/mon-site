<?php
namespace App\Services\Admin;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

interface UserServicesInterface
{

    /**
     * @param Request $request
     *
     * @return array
     */
    public function index(Request $request): array;

    /**
     * @param User $user
     *
     * @return void
     */
    public function create(User $user): void;

    /**
     * @param User $user
     *
     * @return void
     */
    public function edit(User $user): void;

    /**
     * @param User $user
     *
     * @return object
     */
    public function delete(User $user): object;

}
