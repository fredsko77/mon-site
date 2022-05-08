<?php
namespace App\Controller\Admin;

use App\Entity\Board;
use App\Entity\Card;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/card", name="admin_card_")
 */
class CardController extends AbstractController
{

    /**
     * @var CardServicesInterface $service
     */
    private $service;

    public function __construct(
        // CardServicesInterface $service
    ) {
        // $this->service = $service;
    }

    /**
     * @Route(
     *  "/{id}",
     *  name="show",
     *  methods={"GET"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function show(Card $card): Response
    {
        return $this->render('task-manager/card/index.html.twig', compact('card'));
    }

    /**
     * @Route(
     *  "/{id}",
     *  name="new",
     *  methods={"GET", "POST"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function create(Board $board): Response
    {
        return $this->render('task-manager/card/create.html.twig', compact('board'));
    }

}
