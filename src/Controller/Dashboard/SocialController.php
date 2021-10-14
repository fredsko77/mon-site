<?php
namespace App\Controller\Dashboard;

use App\Entity\Social;
use App\Form\SocialType;
use App\Repository\SocialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard/social", name="dashboard_social")
 */
class SocialController extends AbstractController
{

    /**
     *@var EntityManagerInterface $manager
     */
    private $manager;

    /**
     *@var SocialRepository $repository
     */
    private $repository;

    public function __construct(EntityManagerInterface $manager, SocialRepository $repository)
    {
        $this->manager = $manager;
        $this->repository = $repository;
    }

    /**
     * @Route(
     *  "",
     *  name="_list",
     *  methods={"GET"}
     * )
     */
    public function index(): Response
    {
        return $this->render('dashboard/social/index.html.twig', [
            'socials' => $this->repository->findAll(),
        ]);
    }

    /**
     * @Route(
     *  "/create",
     *  name="_create",
     *  methods={"GET", "POST"}
     * )
     */
    public function create(Request $request): Response
    {
        $form = $this->createForm(SocialType::class, (new Social), [
            'method' => 'POST',
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $social = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $this->manager->persist($social);
            $this->manager->flush();

            return $this->redirectToRoute('dashboard_social_edit', [
                'id' => $social->getId(),
            ]);
        }

        return $this->render('dashboard/social/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(
     *  "/{id}/edit",
     *  name="_edit",
     *  methods={"GET", "POST"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function edit(Request $request, Social $social): Response
    {
        $form = $this->createForm(SocialType::class, $social, [
            'method' => 'POST',
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $social = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $this->manager->persist($social);
            $this->manager->flush();

            return $this->redirectToRoute('dashboard_social_edit', [
                'id' => $social->getId(),
            ]);
        }

        return $this->render('dashboard/social/edit.html.twig', [
            'form' => $form->createView(),
            'social' => $social,
        ]);
    }

    /**
     * @Route(
     *  "/{id}",
     *  name="_delete",
     *  methods={"DELETE"},
     *  requirements={"id": "\d+"}
     * )
     */
    public function delete(Social $social): JsonResponse
    {
        $this->manager->remove($social);
        $this->manager->flush();

        return $this->json(
            [],
            Response::HTTP_NO_CONTENT,
            [
                'Location' => $this->generateUrl('dashboad_social_list'),
            ]
        );
    }

}
