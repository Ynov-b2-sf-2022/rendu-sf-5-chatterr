<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category/{categoryId}', name: 'app_category')]
    public function index(string $categoryId, CategoryRepository $categoryRepository): Response
    {

        //retrieve the informations about the category based on the category name
        $category = $categoryRepository->findOneBy(['id' => $categoryId]);

        return $this->render('category/index.html.twig', [
            'category' => $category,
        ]);
    }
}
