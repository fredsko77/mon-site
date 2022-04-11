<?php
namespace App\Controller\Admin\Api;

use App\Entity\Card;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/api/card", name="admin_card_")
 */
class ApiCardController extends AbstractController
{

    public function __construct()
    {

    }

    /**
     * @Route(
     *  "/{id}/file/new",
     *  name="file_new"
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
     *  name="file_delete"
     *  methods={"DELETE"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function deleteCardFile(Card $card): JsonResponse
    {
        return $this->json([]);
    }
}
