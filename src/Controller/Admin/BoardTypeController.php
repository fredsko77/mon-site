<?php
namespace App\Controller\Admin;

use App\Entity\BoardType;
use App\Services\Admin\BoardTypeServicesInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/boardType", name="admin_boardType_")
 */
class BoardTypeController extends AbstractController
{

    /**
     * @var BoardTypeServicesInterface $service
     */
    private $service;

    public function __construct(BoardTypeServicesInterface $service)
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
    public function index(): Response
    {
        return $this->render('admin/task-manager/index.html.twig', $this->service->index());
    }

    /**
     * @Route(
     *  "/new",
     *  name="new",
     *  methods={"GET", "POST"}
     * )
     */
    public function create(): Response
    {
        return $this->render('', []);
    }

    /**
     * @Route(
     *  "/{id}",
     *  name="show",
     *  methods={"GET", "POST"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function show(BoardType $boardType): Response
    {
        return $this->render('', []);
    }

    /**
     * @Route(
     *  "/{id}/edit",
     *  name="edit",
     *  methods={"GET", "POST"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function edit(BoardType $boardType): Response
    {
        return $this->render('', []);
    }

    /**
     * @Route(
     *  "/{id}/delete",
     *  name="delete",
     *  methods={"DELETE"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function delete(BoardType $boardType): JsonResponse
    {
        return $this->json([]);
    }

    /**
     * @Route(
     *  "/board/new",
     *  name="new_board",
     *  methods={"GET", "POST"}
     * )
     */
    public function newBoard(BoardType $boardType): Response
    {
        return $this->render('', []);
    }

}
