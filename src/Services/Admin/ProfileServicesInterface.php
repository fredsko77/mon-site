<?php
namespace App\Services\Admin;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

interface ProfileServicesInterface
{

    /**
     * @param Request $request
     * @param User $user
     *
     * @return object
     */
    public function changePassword(Request $request, User $user): object;

    /**
     * @param Request $request
     *
     * @return object
     */
    public function deleteImage(User $user): object;

    /**
     * @param Request $request
     * @param User $user
     *
     * @return object
     */
    public function edit(Request $request, User $user): object;

    /**
     * @param Request $request
     * @param User $user
     *
     * @return object
     */
    public function uploadImage(Request $request, User $user): object;

}
