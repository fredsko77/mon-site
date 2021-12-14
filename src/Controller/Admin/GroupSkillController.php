<?php

namespace App\Controller\Admin;

use App\Entity\GroupSkil;
use App\Form\GroupSkilType;
use App\Repository\GroupSkilRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/group/skill')]
class GroupSkillController extends AbstractController
{
    #[Route('/', name: 'admin_group_skill_index', methods: ['GET'])]
    public function index(GroupSkilRepository $groupSkilRepository): Response
    {
        return $this->render('admin/group_skill/index.html.twig', [
            'group_skils' => $groupSkilRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_group_skill_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $groupSkil = new GroupSkil();
        $form = $this->createForm(GroupSkilType::class, $groupSkil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($groupSkil);
            $entityManager->flush();

            return $this->redirectToRoute('admin_group_skill_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/group_skill/new.html.twig', [
            'group_skil' => $groupSkil,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_group_skill_show', methods: ['GET'])]
    public function show(GroupSkil $groupSkil): Response
    {
        return $this->render('admin/group_skill/show.html.twig', [
            'group_skil' => $groupSkil,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_group_skill_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, GroupSkil $groupSkil, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GroupSkilType::class, $groupSkil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_group_skill_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/group_skill/edit.html.twig', [
            'group_skil' => $groupSkil,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_group_skill_delete', methods: ['POST'])]
    public function delete(Request $request, GroupSkil $groupSkil, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$groupSkil->getId(), $request->request->get('_token'))) {
            $entityManager->remove($groupSkil);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_group_skill_index', [], Response::HTTP_SEE_OTHER);
    }
}
