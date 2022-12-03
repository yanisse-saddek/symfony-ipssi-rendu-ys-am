<?php
namespace App\Controller;

use App\Form\SortType;
use DateTimeImmutable;
use App\Entity\Article;
use App\Entity\Category;
use App\Form\ArticleType;
use App\Form\CategoryType;
use App\Form\UserFilterType;
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
    public function adminHomepage(ArticleRepository $articleRepository, ProductRepository $productRepository, CategoryRepository $categoryRepository, UserRepository $userRepository): Response
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


    #Articles 
    #[Route('/articles', name: 'app_admin_article', methods: ['GET', 'POST'])]
    public function articlePage(Request $request, ArticleRepository $articleRepository): Response
    {
        // create form sorttype
        $form = $this->createForm(SortType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $filter = $form->get('sort')->getData();
            $articles = $articleRepository->findByOrder($filter);
        }else{
            $articles = $articleRepository->findAll();
        }

        return $this->render('admin/articles.html.twig', [
            'articles' => $articles,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/article/new', name: 'app_article_new', methods: ['GET', 'POST'])]
    public function createNewArticle(Request $request, ArticleRepository $articleRepository): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $article->setCreatedAt(new DateTimeImmutable('now'));
            $article->setUpdatedAt(new DateTimeImmutable('now'));
            $article->setPublished(true);
            $articleRepository->save($article, true);

            return $this->redirectToRoute('app_admin_article', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/article/{id}/edit', name: 'app_article_edit', methods: ['GET', 'POST'])]
    public function editArticle(Request $request, Article $article, ArticleRepository $articleRepository): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setUpdatedAt(new DateTimeImmutable('now'));
            $articleRepository->save($article, true);

            return $this->redirectToRoute('app_admin_article', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/article/{id}/{status}', name: 'app_article_status', methods: ['POST'])]
    public function changeArticleStatus(Request $request, Article $article, ArticleRepository $articleRepository, $status): Response
    {
        if ($this->isCsrfTokenValid('status'.$article->getId(), $request->request->get('_token'))) {
            $article->setPublished($status);
            $articleRepository->save($article, true);
        }


        return $this->redirectToRoute('app_admin_article', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/article/{id}', name: 'app_article_delete', methods: ['POST'])]
    public function deleteArticle(Request $request, Article $article, ArticleRepository $articleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $articleRepository->remove($article, true);
        }

        return $this->redirectToRoute('app_admin_article', [], Response::HTTP_SEE_OTHER);
    }

    #Products
    #[Route('/products', name: 'app_admin_product', methods: ['GET', 'POST'])]
    public function productPage(Request $request, ProductRepository $productRepository): Response
    {
        $sortForm = $this->createForm(SortType::class);
        $sortForm->handleRequest($request);
        
        if($sortForm->isSubmitted() && $sortForm->isValid()) {
            $filter = $sortForm->get('sort')->getData();
            $products = $productRepository->findByOrder($filter);
        } else{
            $products = $productRepository->findAll();
        }

        return $this->render('admin/products.html.twig', [
            'products' => $products,
            'sortForm' => $sortForm->createView(),
        ]);
    }

    // Categories
    #[Route('/category', name: 'app_admin_category', methods: ['GET', 'POST'])]
    public function categoryPage(Request $request, CategoryRepository $categoryRepository, ProductRepository $productRepository): Response
    {
        $form = $this->createForm(SortType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sort = $form->get('sort')->getData();
            $categories = $categoryRepository->orderByCreatedAt($sort);
        } else {
            $categories = $categoryRepository->findAll();
        }

        return $this->render('admin/category.html.twig', [
            'categories' => $categories,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/category/new', name: 'app_admin_category_new', methods: ['GET', 'POST'])]
    public function createCategory(Request $request, CategoryRepository $categoryRepository): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category->setCreatedAt(new DateTimeImmutable('now'));
            $categoryRepository->save($category, true);

            return $this->redirectToRoute('app_admin_category', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/admin/category/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }
    #[Route('/category/{id}/edit', name: 'app_admin_category_edit', methods: ['GET', 'POST'])]
    public function editCategory(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->save($category, true);

            return $this->redirectToRoute('app_admin_category', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/category/{id}', name: 'app_admin_category_delete', methods: ['POST'])]
    public function deleteCategory(Request $request, Category $category, CategoryRepository $categoryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $categoryRepository->remove($category, true);
        }

        return $this->redirectToRoute('app_admin_category', [], Response::HTTP_SEE_OTHER);
    }



    // Users
    #[Route('/user', name: 'app_admin_user', methods: ['GET', 'POST'])]
    public function userPage(Request $request, UserRepository $userRepository): Response
    { 
        $form = $this->createForm(UserFilterType::class);
        $form->handleRequest($request);
        $users = $userRepository->findAll();

        if($form->isSubmitted() && $form->isValid()) {
            $users = $userRepository->findUserByRole($form->get('status')->getData());
        }
        
        return $this->render('admin/user.html.twig', [
            'users' => $users,
            'form' => $form->createView(),
        ]);
    }
}


?>