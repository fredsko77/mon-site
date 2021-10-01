<?php

namespace App\Controller\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard/skill", name="dashboard_skill")
 */
class SkillController extends AbstractController
{
    /**
     * @Route("", name="_list", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin/skill/index.html.twig', [
            'controller_name' => 'SkillController',
        ]);
    }
}
