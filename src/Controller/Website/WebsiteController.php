<?php
namespace App\Controller\Website;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Services\WebSiteServices;
use App\Services\WebSiteServicesInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class WebsiteController extends AbstractController
{

    /**
     * @var WebSiteServicesInterface $service
     */
    private $service;

    public function __construct(WebSiteServicesInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @Route(
     *  "/me-contacter",
     *  name="website_contact",
     *  methods={"GET", "POST"}
     * )
     */
    public function contact(Request $request): Response
    {
        $contact = new Contact;
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->service->contact($contact);

            $this->addFlash('info', 'Nous avons bien pris en compte votre demande !');

            return $this->redirectToRoute('website_contact');
        }

        return $this->render('site/contact.html.twig', [
            'form' => $form->createView(),
        ]);
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
