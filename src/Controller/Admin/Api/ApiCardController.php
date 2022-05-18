<?php
namespace App\Controller\Admin\Api;

use App\Entity\Board;
use App\Entity\BoardList;
use App\Entity\Card;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/api/card", name="admin_api_card_")
 */
class ApiCardController extends AbstractController
{

    public function __construct()
    {

    }

    /**
     * @Route(
     *  "/create/board",
     *  name="board_create",
     *  methods={"POST"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function boardCreateCard(Board $board, Request $request): JsonResponse
    {
        return $this->json([]);
    }

    /**
     * @Route(
     *  "/create/list",
     *  name="list_create",
     *  methods={"POST"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function listCreateCard(BoardList $board, Request $request): JsonResponse
    {
        return $this->json([]);
    }

    /**
     * @Route(
     *  "/{id}/file/new",
     *  name="file_new",
     *  methods={"POST"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function newCardFile(Card $card): JsonResponse
    {
        return $this->json([]);
    }

    /**
     * @Route(
     *  "/file/{id}",
     *  name="file_delete",
     *  methods={"DELETE"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function deleteCardFile(Card $card): JsonResponse
    {
        return $this->json([]);
    }
}
