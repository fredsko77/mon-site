<?php
namespace App\Controller\Website;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LegalController extends AbstractController
{

    public function __construct()
    {

    }

    /**
     * @Route(
     *  "/mentions-legales",
     *  name="website_mentions_legales",
     *  methods={"GET"}
     * )
     */
    public function mentionsLegales(): Response
    {
        return $this->render('site/mentions_legales.html.twig');
    }

}
