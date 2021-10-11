<?php
namespace App\Controller\Dashboard;

use App\Entity\User;
use App\Services\Dashboard\ProfileServicesInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/dashboard/profile", name="dashboard_profile_")
 */
class ProfileController extends AbstractController
{

    /**
     * @var ProfileServicesInterface $service
     */
    private $service;

    public function __construct(ProfileServicesInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @Route(
     *  "/{uid}/change-password",
     *  name="change_password",
     *  methods={"PUT"}
     * )
     */
    public function changePassword(Request $request, User $user): JsonResponse
    {
        return $this->json([]);
    }

    /**
     * @Route(
     *  "/{uid}/delete-image",
     *  name="delete_image",
     *  methods={"DELETE"}
     * )
     */
    public function deleteImage(Request $request, User $user): JsonResponse
    {
        return $this->json([]);
    }

    /**
     * @Route(
     *  "/{uid}/edit",
     *  name="edit",
     *  methods={"PUT"}
     * )
     */
    public function edit(Request $request, User $user): JsonResponse
    {
        $response = $this->service->edit($request, $user);

        return $this->json(
            $response->data,
            $response->status,
            $response->headers,
            ['groups' => 'user:read']
        );
    }

    /**
     * @Route(
     *  "/{uid}/upload-image",
     *  name="upload_image",
     *  methods={"POST"})
     */
    public function uploadImage(Request $request): JsonResponse
    {
        return $this->json([]);
    }

}
