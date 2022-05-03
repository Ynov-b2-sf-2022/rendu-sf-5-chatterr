<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\InsertMessageType;
use App\Service\ExperienceService;
use App\Repository\CategoryRepository;
use App\Repository\GradeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InsertMessageController extends AbstractController
{
    #[Route('/category/{categoryId}/insert/message', name: 'app_insert_message')]
    public function index(GradeRepository $gradeRepository, ExperienceService $experienceService, UserRepository $userRepository, Request $request, string $categoryId, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository): Response
    {
        $message = new Message();
        $messageForm = $this->createForm(InsertMessageType::class, $message);
        $messageForm->handleRequest($request);
        $user = $this->getUser();

        if ($messageForm->isSubmitted() && $messageForm->isValid()) {
            //retrieve a category by its name
            $category = $categoryRepository->findOneBy(['name' => $categoryId]);

            $message->setCategory($category)
                ->setUser($this->getUser())
                ->setContent($messageForm->get('content')->getData());

            $exp = $experienceService->getExperience($userRepository, $user->getUserIdentifier());

            if ($exp <= 100) {
                //manage the user experience
                $user->setExperience($exp+1);
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
            $entityManager->persist($message);
            $entityManager->flush();
            
            return $this->redirectToRoute('app_index');
        }

        return $this->render('insert_message/index.html.twig', [
            'controller_name' => 'InsertMessageController',
            'form' => $messageForm->createView(),
        ]);
    }
}
