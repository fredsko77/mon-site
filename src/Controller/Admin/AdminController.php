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
     * @Route("", name="", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->redirectToRoute('admin_project_list');
    }

}
