<?php
namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\UserRepository;
use App\Repository\ArticleRepository;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/articles', name: 'app_admin_article', methods: ['GET'])]
    public function articlePage(ArticleRepository $articleRepository): Response
    {
        return $this->render('admin/articles.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    #[Route('/products', name: 'app_admin_product', methods: ['GET'])]
    public function productPage(ProductRepository $productRepository): Response
    {
        return $this->render('admin/products.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    // Categories
    #[Route('/category', name: 'app_admin_category', methods: ['GET'])]
    public function categoryPage(CategoryRepository $categoryRepository): Response
    {
        return $this->render('admin/category.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/category/new', name: 'app_admin_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CategoryRepository $categoryRepository): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->save($category, true);

            return $this->redirectToRoute('app_admin_category', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('category/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }




    #[Route('/user', name: 'app_admin_user', methods: ['GET'])]
    public function userPage(UserRepository $userRepository): Response
    {
        return $this->render('admin/user.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }
}


?>