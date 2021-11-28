<?php
namespace App\Controller\Admin;

use App\Entity\User;
use App\Services\Admin\ProfileServicesInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/admin/profile", name="admin_profile_")
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
     *  "/{id}/upload-image",
     *  name="upload_image",
     *  methods={"POST"})
     */
    public function uploadImage(Request $request, User $user): JsonResponse
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
     *  "/{id}/upload-resume",
     *  name="upload_resume",
     *  methods={"POST"}
     * )
     */
    public function uploadResume(Request $request, User $user): JsonResponse
    {
        $response = $this->service->edit($request, $user);

        return $this->json(
            $response->data,
            $response->status,
            $response->headers,
            ['groups' => 'user:read']
        );

    }

}
