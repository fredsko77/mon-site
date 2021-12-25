<?php

namespace App\Controller\Admin;

use App\Entity\GroupSkill;
use App\Form\Admin\GroupSkillType;
use App\Repository\GroupSkillRepository;
use App\Services\Admin\SkillServices;
use App\Services\Admin\SkillServicesInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(
 *  "/admin/group/skill",
 *  name="admin_group_skill_"
 * )
 **/
class GroupSkillController extends AbstractController
{

    /**
     * @var SkillServicesInterface $service
     */
    private $service;

    public function __construct(SkillServicesInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @Route(
     *  "",
     *  name="list",
     *  methods={"GET"}
     * )
     **/
    public function index(GroupSkillRepository $groupSkillRepository): Response
    {
        return $this->render('admin/group_skill/index.html.twig', [
            'group_skils' => $groupSkillRepository->findAll(),
        ]);
    }

    /**
     * @Route(
     *  "/create",
     *  name="new",
     *  methods={"GET", "POST"}
     * )
     **/
    public function create(Request $request): Response
    {
        $groupSkill = new GroupSkill();
        $form = $this->createForm(GroupSkillType::class, $groupSkill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->service->store($groupSkill, $form);

            return $this->redirectToRoute('admin_group_skill_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/group_skill/new.html.twig', [
            'group_skil' => $groupSkill,
            'form' => $form,
        ]);
    }

    /**
     * @Route(
     *  "/{id}/edit",
     *  name="edit",
     *  methods={"GET", "POST"},
     *  requirements={"id":"\d+"}
     * )
     **/
    public function edit(Request $request, GroupSkill $groupSkill, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GroupSkillType::class, $groupSkill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->service->store($groupSkill, $form);

            return $this->redirectToRoute('admin_group_skill_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/group_skill/edit.html.twig', [
            'group_skil' => $groupSkill,
            'form' => $form,
        ]);
    }

    /**
     * @Route(
     *  "/{id}",
     *  name="delete",
     *  methods={"POST"},
     *  requirements={"id"="\d+"}
     * )
     **/
    public function delete(Request $request, GroupSkill $groupSkill, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $groupSkill->getId(), $request->request->get('_token'))) {
            $entityManager->remove($groupSkill);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_group_skill_list', [], Response::HTTP_SEE_OTHER);
    }
}
