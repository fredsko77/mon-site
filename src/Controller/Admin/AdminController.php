<?php
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin")
 */
class AdminController extends AbstractController
{

    /**
     * @Route("/profile", name="_profile", methods={"GET"})
     * @Route("", name="", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render("/admin/profile/index.html.twig");
    }

}
