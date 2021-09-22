<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SkillController extends AbstractController
{
    /**
     * @Route("/admin/skill", name="admin_skill")
     */
    public function index(): Response
    {
        return $this->render('admin/skill/index.html.twig', [
            'controller_name' => 'SkillController',
        ]);
    }
}
