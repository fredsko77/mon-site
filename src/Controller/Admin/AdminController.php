<?php
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{

    /**
     * @Route("/profile", name="admin_profile", methods={"GET"})
     * @Route("", name="admin", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render("/admin/profile/index.html.twig");
    }

}
