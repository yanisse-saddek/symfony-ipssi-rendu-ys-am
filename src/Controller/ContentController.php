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

    #[Route('/products', name: 'app_product_index', methods: ['GET', 'POST'])]
    public function productPage(Request $request, ProductRepository $productRepository): Response
    {
        return $this->redirectToRoute('app_products_filter', [
            'filter' => 'asc',
        ]);
    }

    #[Route('/products/{filter}', name: 'app_products_filter', methods: ['GET', 'POST'])]
    public function showProducts(Request $request, $filter, ProductRepository $productRepository): Response
    {
        $form = $this->createForm(ProductFilterType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $filter = $form->get('filter')->getData();
            return $this->redirectToRoute('app_products_filter', ['filter'=>$filter]);
        } 


        return $this->render('content/products.html.twig', [
            'products' => $productRepository->findByOrder($filter),
            'form'=>$form->createView(),
        ]);
    }


    #[Route('/show/{id}', name: 'app_product', methods: ['GET'])]
    public function showProduct(Product $product): Response
    {
        // check if user have ROLE_USER
        if (!$this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('content/product/product.html.twig', [
            'product' => $product,
        ]);
    }
}
