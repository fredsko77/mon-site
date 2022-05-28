<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Services\Admin\UserServicesInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/user", name="admin_user_")
 */
class UserController extends AbstractController
{

    /**
     * @var UserServicesInterface $service
     */
    private $service;

    public function __construct(UserServicesInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @Route(
     *  "",
     *  name="index",
     *  methods={"GET"}
     * )
     */
    public function index(Request $request): Response
    {
        return $this->render('admin/user/index.html.twig', $this->service->index($request));
    }

    /**
     * @Route(
     *  "/create",
     *  name="create",
     *  methods={"GET", "POST"}
     * )
     */
    public function create(Request $request): Response
    {
        return $this->renderForm('admin/user/create.html.twig');
    }

    /**
     * @Route(
     *  "/{id}",
     *  name="edit",
     *  methods={"GET", "POST"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function edit(User $user, Request $request): Response
    {
        $form = $this->createForm('');

        return $this->renderForm('admin/user/edit.html.twig', compact('form', 'user'));
    }

    /**
     * @Route(
     *  "/{id}",
     *  name="delete",
     *  methods={"DELETE"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function delete(): JsonResponse
    {
        return $this->json([], Response::HTTP_NO_CONTENT);
    }

}
