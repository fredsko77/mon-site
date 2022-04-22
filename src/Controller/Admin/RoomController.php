<?php
namespace App\Controller\Admin;

use App\Entity\Board;
use App\Entity\Room;
use App\Form\Admin\RoomType;
use App\Form\Board\BoardCreateType;
use App\Services\Admin\BoardServicesInterface;
use App\Services\Admin\RoomServicesInterface;
use App\Utils\FakerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/room", name="admin_room_")
 */
class RoomController extends AbstractController
{

    use FakerTrait;

    /**
     * @var RoomServicesInterface $service
     */
    private $service;

    /**
     * @var BoardServicesInterface $boardService
     */
    private $boardService;

    public function __construct(RoomServicesInterface $service, BoardServicesInterface $boardService)
    {
        $this->service = $service;
        $this->boardService = $boardService;
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
        return $this->render('task-manager/index.html.twig', $this->service->index());
    }

    /**
     * @Route(
     *  "/new",
     *  name="new",
     *  methods={"GET", "POST"}
     * )
     */
    public function create(Request $request): Response
    {
        $room = new Room;
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->service->store($room);

            return $this->redirectToRoute('admin_room_edit', [
                'id' => $room->getId(),
            ]);
        }

        return $this->renderForm('task-manager/room/new.html.twig', compact('form'));
    }

    /**
     * @Route(
     *  "/{id}",
     *  name="show",
     *  methods={"GET", "POST"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function show(Room $room, Request $request): Response
    {
        return $this->render('task-manager/room/show.html.twig', $this->service->show($room, $request));
    }

    /**
     * @Route(
     *  "/{id}/edit",
     *  name="edit",
     *  methods={"GET", "POST"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function edit(Room $room, Request $request): Response
    {
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->service->store($room);

            return $this->redirectToRoute('admin_room_edit', [
                'id' => $room->getId(),
            ]);
        }

        return $this->renderForm('task-manager/room/edit.html.twig', compact('form'));
    }

    /**
     * @Route(
     *  "/{id}",
     *  name="delete",
     *  methods={"DELETE"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function delete(Room $room): JsonResponse
    {
        $response = $this->service->delete($room);

        return $this->json(
            $response->data,
            $response->status,
            $response->headers
        );
    }

    /**
     * @Route(
     *  "/{id}/board/new",
     *  name="new_board",
     *  methods={"GET", "POST"}
     * )
     */
    public function newBoard(Room $room, Request $request): Response
    {
        $board = new Board;
        $form = $this->createForm(BoardCreateType::class, $board);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->boardService->create($form, $board, $room);

            return $this->redirectToRoute('admin_board_show', [
                'id' => $board->getId(),
            ]);
        }

        return $this->renderForm('task-manager/board/new.html.twig', compact('form'));
    }

}
