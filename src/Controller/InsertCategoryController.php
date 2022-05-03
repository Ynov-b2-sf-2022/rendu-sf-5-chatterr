<?php

namespace App\Controller;

use App\Form\CategoryType;


use Symfony\Component\HttpFoundation\Request;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ExperienceService;
use App\Service\GradeService;
use App\Repository\CategoryRepository;
use App\Repository\GradeRepository;
use App\Repository\UserRepository;

class InsertCategoryController extends AbstractController
{
    #[Route('/insert/category', name: 'app_insert_category')]
    public function index(GradeRepository $gradeRepository, GradeService $gradeService, ExperienceService $experienceService, UserRepository $userRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = new Category();
        $categoryForm = $this->createForm(CategoryType::class, $category);
        $categoryForm->handleRequest($request);

        if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {
            //check if category already exists, if so send message to user
            $categoryRepository = $entityManager->getRepository(Category::class);
            $testCategory = $categoryRepository->findOneBy(['name' => $category->getName()]);
            if ($testCategory) {
                $this->addFlash('success', 'Categorie déjà existante');
                // return $this->redirectToRoute('app_index');
            } else {
                $category->setName($categoryForm->get('name')->getData())
                    ->setUser($this->getUser());

            $exp = $experienceService->getExperience($userRepository, $this->getUser()->getUserIdentifier());

                if ($exp <= 100) {
                    //manage the user experience
                    $experienceService->setExperience($userRepository, $this->getUser()->getUserIdentifier(), $exp + 5);
                        
                    //manage the user grade
                    $grade = $gradeService->getGrade($userRepository, $this->getUser()->getUserIdentifier());
                    $gradeService->setGrade($userRepository, $gradeRepository, $this->getUser()->getUserIdentifier(), intval($exp / 25) + 1);
                }

                $entityManager->persist($category);
                $entityManager->flush();
                $this->addFlash('success', 'Categorie ajoutée');
                return $this->redirectToRoute('app_index');
            }
        }

        return $this->render('insert_category/index.html.twig', [
            'controller_name' => 'InsertCategoryController',
            'form' => $categoryForm->createView(),
        ]);
    }
}
