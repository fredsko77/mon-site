<?php
namespace App\Controller\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard")
 */
class DashboardController extends AbstractController
{

    /**
     * @Route("", name="dashboard", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render("/dashboard/profile/index.html.twig");
    }

}
