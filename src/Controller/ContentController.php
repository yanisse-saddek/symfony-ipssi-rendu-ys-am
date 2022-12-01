<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/')]
class ContentController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): Response
    {
        $latestArticles = $articleRepository->findLatestArticles(3);

        return $this->render('article/index.html.twig', [
            'articles' => $latestArticles,
        ]);
    }

    #[Route('/products', name: 'app_products', methods: ['GET'])]
    public function showProducts(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

}
