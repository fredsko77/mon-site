<?php
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class DashboardController extends AbstractController
{

    /**
     * @Route("", name="admin_default", methods={"GET"})
     * @Route("/dashboard", name="admin_dashboard", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render("/admin/index.html.twig");
    }

}