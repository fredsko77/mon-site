<?php
namespace App\Controller\Website;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class WebsiteController extends AbstractController
{

    public function __construct()
    {}

    /**
     * @Route(
     *  "/me-contacter",
     *  name="website_contact",
     *  methods={"GET", "POST"}
     * )
     */
    public function contact(Request $request): Response
    {

        return $this->renderForm('site/contact.html.twig');
    }

    /**
     * @Route(
     *  "/telecharger-mon-cv",
     *  name="website_download_resume",
     *  methods={"GET"}
     * )
     */
    public function resume(): BinaryFileResponse
    {
        return $this->file(
            $this->getParameter('root_directory') . '/agathe_frederick_cv.pdf',
            'cv_agathe_frederick.pdf',
            ResponseHeaderBag::DISPOSITION_ATTACHMENT
        );
    }

    /**
     * @Route(
     *  "/qui-suis-je",
     *  name="website_about",
     *  methods={"GET"}
     * )
     */
    public function about(): Response
    {
        return $this->render('site/about.html.twig');
    }

}
