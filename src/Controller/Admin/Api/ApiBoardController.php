<?php
namespace App\Controller\Admin\Api;

use App\Entity\Board;
use App\Services\Admin\BoardServicesInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/api/board", name="admin_api_board_")
 */
class ApiBoardController extends AbstractController
{

    /**
     * @var BoardServicesInterface $service
     */
    private $service;

    public function __construct(
        BoardServicesInterface $service
    ) {
        $this->service = $service;
    }

    /**
     * @Route(
     *  "/{id}/toggle",
     *  name="toggle",
     *  methods={"PUT"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function toggle(Board $board): JsonResponse
    {
        $response = $this->service->toggle($board);

        return $this->json(
            $response->data,
            $response->status,
            $response->headers,
            ['groups' => 'board:read']
        );
    }

}
