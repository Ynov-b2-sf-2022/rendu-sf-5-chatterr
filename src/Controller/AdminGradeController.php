<?php

namespace App\Controller;

use App\Entity\Grade;
use App\Form\GradeType;
use App\Repository\GradeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/grade')]
class AdminGradeController extends AbstractController
{
    #[Route('/', name: 'app_admin_grade_index', methods: ['GET'])]
    public function index(GradeRepository $gradeRepository): Response
    {
        return $this->render('admin_grade/index.html.twig', [
            'grades' => $gradeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_grade_new', methods: ['GET', 'POST'])]
    public function new(Request $request, GradeRepository $gradeRepository): Response
    {
        $grade = new Grade();
        $form = $this->createForm(GradeType::class, $grade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $gradeRepository->add($grade);
            return $this->redirectToRoute('app_admin_grade_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_grade/new.html.twig', [
            'grade' => $grade,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_grade_show', methods: ['GET'])]
    public function show(Grade $grade): Response
    {
        return $this->render('admin_grade/show.html.twig', [
            'grade' => $grade,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_grade_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Grade $grade, GradeRepository $gradeRepository): Response
    {
        $form = $this->createForm(GradeType::class, $grade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $gradeRepository->add($grade);
            return $this->redirectToRoute('app_admin_grade_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_grade/edit.html.twig', [
            'grade' => $grade,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_grade_delete', methods: ['POST'])]
    public function delete(Request $request, Grade $grade, GradeRepository $gradeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$grade->getId(), $request->request->get('_token'))) {
            $gradeRepository->remove($grade);
        }

        return $this->redirectToRoute('app_admin_grade_index', [], Response::HTTP_SEE_OTHER);
    }
}
