<?php
namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\ArticleRepository;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository, ProductRepository $productRepository, CategoryRepository $categoryRepository, UserRepository $userRepository): Response
    {
        return $this->render('admin/index.html.twig', [
            'articleCount' => $articleRepository->count([]),
            'productCount' => $productRepository->count([]),
            'categoryCount' => $categoryRepository->count([]),
            'userCount' => $userRepository->count([]),    
            'articles' => $articleRepository->findAll(),
            'products' => $productRepository->findAll(),
        ]);
    }
}


?>