<?php

namespace App\Controller;

use App\Form\CategoryType;


use Symfony\Component\HttpFoundation\Request;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\ExperienceService;
use App\Repository\CategoryRepository;
use App\Repository\GradeRepository;
use App\Repository\UserRepository;

class InsertCategoryController extends AbstractController
{
    #[Route('/insert/category', name: 'app_insert_category')]
    public function index(GradeRepository $gradeRepository, ExperienceService $experienceService, UserRepository $userRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = new Category();
        $categoryForm = $this->createForm(CategoryType::class, $category);
        $categoryForm->handleRequest($request);
        $user = $this->getUser();

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

                    $exp = $experienceService->getExperience($userRepository, $user->getUserIdentifier());

                    if ($exp <= 100) {
                        //manage the user experience
                        $user->setExperience($exp+5);
                        // $experienceService->setExperience($userRepository, $this->getUser()->getUserIdentifier(), $exp + 1);
                    }
        
                    //manage the user grade
                    $exp = $user->getExperience();
                    $roundedValue = intval($exp / 25);
                    if ($roundedValue > 4) {
                        $roundedValue = 4;
                    }
        
                    //give the grade corresponding to the xp of the user
                    
                    $grade = $gradeRepository->findAll();
                    // $user->setGrade($grade[$roundedValue]);
                    $count = 0;
                    foreach ($grade as $grad) {
                        if ($count == $roundedValue) {
                            $user->setGrade($grad);
                        }
                        $count ++;
                    }
                    
                $entityManager->persist($user);
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
