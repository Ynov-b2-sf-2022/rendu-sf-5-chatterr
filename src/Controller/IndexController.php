<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MessageRepository;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(MessageRepository $messageRepository, CategoryRepository $categoryRepository): Response
    {
        //retrieve all the messages 
        $messages = $messageRepository->findAll();

        //retrieve last 4 categories
        $categories = $categoryRepository->findBy([], ['id' => 'DESC']);

        $connected = false;

        //check if the user is connected 
        if ($this->getUser()) {
            $connected = true;
        }

        return $this->render('index/index.html.twig', [
            'messages' => $messages,
            'categories' => $categories,
            'connected' => $connected,
        ]);
    }
}
