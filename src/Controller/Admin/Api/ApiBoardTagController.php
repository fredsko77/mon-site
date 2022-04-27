<?php
namespace App\Controller\Admin\Api;

use App\Entity\Board;
use App\Entity\BoardTag;
use App\Services\Admin\BoardTagServicesInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/api/boardTag", name="admin_api_board_tag_")
 */
class ApiBoardTagController extends AbstractController
{

    /**
     * @var BoardTagServicesInterface $service
     */
    private $service;

    public function __construct(BoardTagServicesInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @Route(
     *  "/{id}",
     *  name="edit",
     *  methods={"PUT"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function edit(BoardTag $tag, Request $request): JsonResponse
    {
        $response = $this->service->edit($tag, $request);
        return $this->json(
            $response->data,
            $response->status,
            $response->headers,
            ['groups' => 'tag:read']
        );
    }

    /**
     * @Route(
     *  "/{id}",
     *  name="delete",
     *  methods={"DELETE"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function delete(BoardTag $tag): JsonResponse
    {
        $response = $this->service->delete($tag);

        return $this->json(
            $response->data,
            $response->status,
            $response->headers
        );
    }

    /**
     * @Route(
     *  "/{id}",
     *  name="create",
     *  methods={"POST"},
     *  requirements={"id":"\d+"}
     * )
     */
    public function create(Board $board, Request $request): JsonResponse
    {
        $response = $this->service->create($board, $request);

        return $this->json(
            $response->data,
            $response->status,
            $response->headers,
            ['groups' => 'tag:read']
        );
    }

    /**
     * @Route(
     *  "/{id}/list",
     *  name="list",
     *  methods={"GET"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function listTags(Board $board): JsonResponse
    {
        $response = $this->service->listTags($board);

        return $this->json(
            $response->data,
            $response->status,
            $response->headers,
            ['groups' => 'tag:read']
        );
    }

    /**
     * @Route(
     *  "/{id}",
     *  name="show",
     *  methods={"GET"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function show(BoardTag $tag): JsonResponse
    {
        $response = $this->service->show($tag);

        return $this->json(
            $response->data,
            $response->status,
            $response->headers,
            ['groups' => 'tag:read']
        );
    }

}
