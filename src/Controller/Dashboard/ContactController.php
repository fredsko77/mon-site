<?php

namespace App\Controller\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard/contact", name="dashboard_contact")
 */
class ContactController extends AbstractController
{
    /**
     * @Route("", name="_list", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('dashboard/contact/index.html.twig', [
            'controller_name' => 'AdminContactController',
        ]);
    }
}
