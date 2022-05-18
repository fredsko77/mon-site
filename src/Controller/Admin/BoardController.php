<?php
namespace App\Controller\Admin;

use App\Entity\Board;
use App\Entity\BoardTag;
use App\Form\Board\BoardEditType;
use App\Services\Admin\BoardServicesInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/board", name="admin_board_")
 */
class BoardController extends AbstractController
{

    /**
     * @var BoardServicesInterface $service
     */
    private $service;

    public function __construct(BoardServicesInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @Route(
     *  "/{id}",
     *  name="list",
     *  methods={"GET"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function show(Board $board, Request $request): Response
    {
        return $this->render('task-manager/board/list/index.html.twig', $this->service->filter($board, $request));
    }

    /**
     * @Route(
     *  "/{id}/kanban",
     *  name="kanban",
     *  methods={"GET"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function kanban(Board $board): Response
    {
        return $this->render('task-manager/board/kanban/index.html.twig', $this->service->kanban($board));
    }

    /**
     * @Route(
     *  "/{id}/edit",
     *  name="edit",
     *  methods={"GET", "POST"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function edit(Board $board, Request $request): Response
    {
        $form = $this->createForm(BoardEditType::class, $board);
        $form->handleRequest($request);
        $tagColors = BoardTag::colors();

        if ($form->isSubmitted() && $form->isValid()) {
            $this->service->store($board);

            return $this->redirectToRoute('admin_board_edit', [
                'id' => $board->getId(),
            ]);
        }

        return $this->renderForm('task-manager/board/edit.html.twig', compact('form', 'board', 'tagColors'));
    }

    /**
     * @Route(
     *  "/{id}",
     *  name="delete",
     *  methods={"DELETE"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function delete(Board $board): JsonResponse
    {
        $response = $this->service->delete($board);

        return $this->json(
            $response->data,
            $response->status,
            $response->headers
        );
    }

}
