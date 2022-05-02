<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category/{categoryName}', name: 'app_category')]
    public function index(string $categoryName, CategoryRepository $categoryRepository): Response
    {

        //retrieve the informations about the category based on the category name
        $category = $categoryRepository->findOneBy(['name' => $categoryName]);

        return $this->render('category/index.html.twig', [
            'category' => $category,
        ]);
    }
}
