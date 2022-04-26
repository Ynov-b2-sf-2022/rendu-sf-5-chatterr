<?php

namespace App\Controller;

use App\Entity\Grade;
use App\Entity\User;
use App\Repository\GradeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function index(): Response
    {
        return $this->render('register/index.html.twig', [
            'controller_name' => 'RegisterController',
        ]);
    }

    #[Route('/register', name: 'app_register')]
    public function conectionAction(Request $request, GradeRepository $gradeRepository) {
        
        if ($request->getMethod() == 'POST') {
            $email = $request->request->get('email');

            $grade = new Grade();
            $grade =  $gradeRepository->find(6);

            if ($email != null) {
                $pseudo = $request->request->get('pseudo');
                $password = $request->request->get('password');
                
                $user = new User();
                $user->setEmail($email)
                    ->setUsername($pseudo)
                    ->setPassword($password)
                    ->setExperience(0)
                    ->setGrade($grade);

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
            }
        }
        return $this->render('index/index.html.twig', [
            'controller_name' => 'RegisterController',
        ]);
    }
}