<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/admin/contact", name="admin_contact")
     */
    public function index(): Response
    {
        return $this->render('admin_contact/index.html.twig', [
            'controller_name' => 'AdminContactController',
        ]);
    }
}
