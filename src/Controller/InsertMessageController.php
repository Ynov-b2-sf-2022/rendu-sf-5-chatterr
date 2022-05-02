<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\InsertMessageType;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InsertMessageController extends AbstractController
{
    #[Route('/insert/message', name: 'app_insert_message')]
    public function index(Request $request): Response
    {        
        $message = new Message();
        $messageForm = $this->createForm(InsertMessageType::class, $message);
        $messageForm->handleRequest($request);

        return $this->render('insert_message/index.html.twig', [
            'controller_name' => 'InsertMessageController',
            'form' => $messageForm->createView(),
        ]);
    }
}
