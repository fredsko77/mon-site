<?php

namespace App\Controller\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard/project", name="dashboard_project")
 */
class ProjectController extends AbstractController
{
    /**
     * @Route("", name="_list", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin/project/index.html.twig', [
            'controller_name' => 'ProjectController',
        ]);
    }
}
