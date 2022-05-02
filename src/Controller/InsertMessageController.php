<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\InsertMessageType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InsertMessageController extends AbstractController
{
    #[Route('/category/{categoryName}/insert/message', name: 'app_insert_message')]
    public function index(Request $request, string $categoryName, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository): Response
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
