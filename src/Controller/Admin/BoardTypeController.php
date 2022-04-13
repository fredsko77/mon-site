<?php
namespace App\Controller\Admin;

use App\Entity\BoardType;
use App\Form\Admin\BoardTypeCreateType;
use App\Services\Admin\BoardTypeServicesInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
    public function create(Request $request): Response
    {
        $boardType = new BoardType;
        $form = $this->createForm(BoardTypeCreateType::class, $boardType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->service->store($boardType);

            return $this->redirectToRoute('admin_boardType_edit', [
                'id' => $boardType->getId(),
            ]);
        }

        return $this->renderForm('admin/task-manager/type/new.html.twig', compact('form'));
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
    public function edit(BoardType $boardType, Request $request): Response
    {
        $form = $this->createForm(BoardTypeCreateType::class, $boardType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->service->store($boardType);

            return $this->redirectToRoute('admin_boardType_edit', [
                'id' => $boardType->getId(),
            ]);
        }

        return $this->renderForm('admin/task-manager/type/edit.html.twig', compact('form'));
    }

    /**
     * @Route(
     *  "/{id}",
     *  name="delete",
     *  methods={"DELETE"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function delete(BoardType $boardType): JsonResponse
    {
        $response = $this->service->delete($boardType);

        return $this->json(
            $response->data,
            $response->status,
            $response->headers
        );
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
