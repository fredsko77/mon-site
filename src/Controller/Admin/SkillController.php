<?php

namespace App\Controller\Admin;

use App\Entity\Skill;
use App\Services\Admin\SkillServicesInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/skill", name="admin_skill")
 */
class SkillController extends AbstractController
{

    /**
     *@var SkillServicesInterface $service
     */
    private $service;

    public function __construct(SkillServicesInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @Route(
     *  "",
     *  name="_list",
     *  methods={"GET"}
     * )
     */
    public function index(): Response
    {
        return $this->render('admin/skill/index.html.twig', $this->service->index());
    }

    /**
     * @Route(
     *  "",
     *  name="_create",
     *  methods={"POST"}
     * )
     */
    public function create(Request $request): JsonResponse
    {
        $response = $this->service->create($request);
        return $this->json(
            $response->data,
            $response->status,
            $response->headers,
            ['groups' => 'skill:read']
        );
    }

    /**
     * @Route(
     *  "/{id}",
     *  name="_edit",
     *  methods={"GET"},
     * requirements={"id": "\d+"}
     * )
     */
    public function edit(Skill $skill)
    {
        return $this->render('admin/skill/edit.html.twig', $this->service->edit($skill));
    }

    /**
     * @Route(
     *  "/{id}",
     *  name="_store",
     *  methods={"PUT"},
     * requirements={"id": "\d+"}
     * )
     */
    public function store(Request $request, Skill $skill)
    {
        $response = $this->service->store($request, $skill);

        return $this->json(
            $response->data,
            $response->status,
            $response->headers,
            ['groups' => 'skill:read']
        );
    }

    /**
     * @Route(
     *  "/{id}",
     *  name="_delete",
     *  methods={"DELETE"},
     * requirements={"id": "\d+"}
     * )
     */
    public function delete(Skill $skill): JsonResponse
    {
        $response = $this->service->delete($skill);

        return $this->json(
            $response->data,
            $response->status,
            $response->headers
        );
    }

}
