<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/contact", name="admin_contact")
 */
class ContactController extends AbstractController
{
    /**
     * @Route("", name="_list", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin/contact/index.html.twig', [
            'controller_name' => 'AdminContactController',
        ]);
    }
}
