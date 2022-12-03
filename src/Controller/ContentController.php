<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\User;
use App\Entity\Article;
use App\Entity\Product;
use App\Form\ArticleType;
use App\Entity\CartProduct;
use App\Form\BuyProductType;
use App\Form\ProductFilterType;
use Doctrine\ORM\EntityManager;
use App\Repository\CartRepository;
use App\Repository\ArticleRepository;
use App\Repository\ProductRepository;
use App\Repository\CartProductRepository;
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
            'filter' => 'desc',
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


    #[Route('/show/{id}', name: 'app_product', methods: ['GET', 'POST'])]
    public function showProduct(Request $request, Product $product, CartRepository $cartRepository, CartProductRepository $cartProductRepository): Response
    {
        if (!$this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(BuyProductType::class, null, [
            'choices' =>
                array_combine(
                    range(1, $product->getQuantity()),
                    range(1, $product->getQuantity())
                ),
        ]);


        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $cartId =  $cartRepository->findCartByUser($this->getUser()->getId());
            if(!$cartId) {
                $cart = new Cart();
                $cart->setUser($this->getUser());            

                $cartRepository->save($cart, true);
            }

            $quantity = $form->get('quantity')->getData();
            $cartProduct = new CartProduct();
            $cartProduct->setCartProduct($product);
            $cartProduct->setProductQuantity($quantity);
            $cartProduct->setCart($cartRepository->findCartByUser($this->getUser()->getId()));

            $cartProductRepository->save($cartProduct, true);
                        
            return $this->redirectToRoute('app_product', ['id'=>$product->getId(), 'quantity'=>$quantity]);
        }

        return $this->render('content/product/product.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/profile/{id}', name:'app_profile')]
    public function showProfile(User $user, ProductRepository $productRepository){
        if($user->getId() !== $this->getUser()->getId()){
            return $this->redirectToRoute('app_home');
        }

        return $this->render('content/profile.html.twig', [
            'user' => $user,
            'products'=>$productRepository->getProductByUser($this->getUser())
        ]);
    }   


    #Cart
    #[Route('/cart', name: 'app_cart_index', methods: ['GET'])]
    public function showUserCart(CartRepository $cartRepository, CartProductRepository $cartProduct): Response
    {
        $cartId =  $cartRepository->findCartByUser($this->getUser()->getId());
        $cartProducts = $cartProduct->findBy(['cart'=>$cartId]);
        $products = [];
        $qt = [];
        
        for($i=0; $i<count($cartProducts); $i++){
            if(in_array($cartProducts[$i]->getCartProduct(), $products)){
                $index = array_search($cartProducts[$i]->getCartProduct(), $products);
                $qt[$index] += $cartProducts[$i]->getProductQuantity();
            } else {
                array_push($products, $cartProducts[$i]->getCartProduct());
                array_push($qt, $cartProducts[$i]->getProductQuantity());
            }            
        }
        
        $data  = [
            'products' => $products,
            'qt' => $qt,
        ];

        return $this->render('content/cart.html.twig', [
            'data' => $data,
        ]);
    }

    #Articles

    #[Route('/article/{id}', name: 'app_article_show', methods: ['GET'])]
    public function showArticle(Article $article): Response
    {
        return $this->render('content/article/show.html.twig', [
            'article' => $article,
        ]);
    }

}
