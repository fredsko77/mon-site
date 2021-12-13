<?php

namespace App\Controller\Admin;

use App\Entity\Stack;
use App\Form\Admin\StackType;
use App\Repository\StackRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/stack", name="admin_stack_")
 */
class StackController extends AbstractController
{
    /**
     * @Route("", name="list", methods={"GET"})
     */
    public function index(StackRepository $stackRepository): Response
    {
        return $this->render('admin/stack/index.html.twig', [
            'stacks' => $stackRepository->findAll(),
        ]);
    }

    /**
     * @Route("/create", name="create", methods={"GET", "POST"})
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $stack = new Stack();
        $form = $this->createForm(StackType::class, $stack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($stack);
            $entityManager->flush();

            return $this->redirectToRoute('admin_stack_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/stack/create.html.twig', [
            'stack' => $stack,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Stack $stack, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StackType::class, $stack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_stack_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/stack/edit.html.twig', [
            'stack' => $stack,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Stack $stack, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $stack->getId(), $request->request->get('_token'))) {
            $entityManager->remove($stack);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_stack_list', [], Response::HTTP_SEE_OTHER);
    }
}
