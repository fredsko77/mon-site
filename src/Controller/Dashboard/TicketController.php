<?php
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard/ticket", name="dashboard_ticket")
 */
class TicketController extends AbstractController
{

    public function __construct()
    {
    }

    /**
     * @Route("", name="_list", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin/ticket/index.html.twig');
    }

    /**
     * @Route("/new", name="_new", methods={"GET"})
     */
    public function create(): Response
    {
        return $this->render('admin/ticket/new.html.twig');
    }

}
