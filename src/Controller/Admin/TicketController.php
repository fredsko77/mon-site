<?php
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/ticket")
 */
class TicketController extends AbstractController
{

    public function __construct()
    {
    }

    /**
     * @Route("", name="admin_ticket_list", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin/ticket/index.html.twig');
    }

    /**
     * @Route("/new", name="admin_ticket_new", methods={"GET"})
     */
    public function create(): Response
    {
        return $this->render('admin/ticket/new.html.twig');
    }

}
