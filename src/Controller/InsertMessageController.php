<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\InsertMessageType;
use App\Service\ExperienceService;
use App\Service\GradeService;
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
    #[Route('/category/{categoryName}/insert/message', name: 'app_insert_message')]
    public function index(GradeRepository $gradeRepository, GradeService $gradeService, ExperienceService $experienceService, UserRepository $userRepository, Request $request, string $categoryName, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository): Response
    {
        $message = new Message();
        $messageForm = $this->createForm(InsertMessageType::class, $message);
        $messageForm->handleRequest($request);

        if ($messageForm->isSubmitted() && $messageForm->isValid()) {
            //retrieve a category by its name
            $category = $categoryRepository->findOneBy(['name' => $categoryName]);

            $message->setCategory($category)
                ->setUser($this->getUser())
                ->setContent($messageForm->get('content')->getData());

            $exp = $experienceService->getExperience($userRepository, $this->getUser()->getUserIdentifier());

            if ($exp <= 100) {
                //manage the user experience
                $experienceService->setExperience($userRepository, $this->getUser()->getUserIdentifier(), $exp + 1);
            }

            //manage the user grade
            $grade = $gradeService->getGrade($userRepository, $this->getUser()->getUserIdentifier());

            if (intval($exp / 25) + 1 > 99) {
                $gradeService->setGrade($userRepository, $gradeRepository, $this->getUser()->getUserIdentifier(), 4);
            } else {
                $gradeService->setGrade($userRepository, $gradeRepository, $this->getUser()->getUserIdentifier(), intval($exp / 25) + 1);
            }

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
