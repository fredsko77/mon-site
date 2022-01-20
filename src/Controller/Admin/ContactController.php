<?php

namespace App\Controller\Admin;

use App\Services\Admin\ContactServicesInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/contact", name="admin_contact")
 */
class ContactController extends AbstractController
{

    /**
     * @var ContactServicesInterface $service
     */
    private $service;

    public function __construct(ContactServicesInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @Route("", name="_list", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin/contact/index.html.twig', [
            'contacts' => $this->service->index(),
        ]);
    }
}
