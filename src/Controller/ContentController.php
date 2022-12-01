<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Product;
use App\Form\ArticleType;
use App\Form\ProductFilterType;
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

        return $this->render('content/home.html.twig', [
            'articles' => $latestArticles,
        ]);
    }

    #[Route('/products', name: 'app_products', methods: ['GET'])]
    public function showProducts(Request $request, ProductRepository $productRepository): Response
    {
        $form = $this->createForm(ProductFilterType::class);
        $form->handleRequest($request);

// dd($form);
        return $this->render('content/products.html.twig', [
            'products' => $productRepository->findAll(),
            'form'=>$form->createView(),
        ]);
    }

    #[Route('/product/{id}', name: 'app_product', methods: ['GET'])]
    public function showProduct(Product $product): Response
    {
        return $this->render('content/product/product.html.twig', [
            'product' => $product,
        ]);
    }
}
