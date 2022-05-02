<?php

namespace App\Controller;
use App\Form\CategoryType;


use Symfony\Component\HttpFoundation\Request;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InsertCategoryController extends AbstractController
{
    #[Route('/insert/category', name: 'app_insert_category')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = new Category();
        $categoryForm = $this->createForm(CategoryType::class, $category);
        $categoryForm->handleRequest($request);

        if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {
            

            $category->setName($categoryForm->get('name')->getData())
                ->setUser($this->getUser());
            $entityManager->persist($category);
            $entityManager->flush();

            //print inserted in console
            // $this->addFlash('success', 'Category inserted!');

            return $this->redirectToRoute('app_index');
        }

        return $this->render('insert_category/index.html.twig', [
            'controller_name' => 'InsertCategoryController',
            'form' => $categoryForm->createView(),
        ]);
    }
}
