<?php

namespace App\Controller;

use DateTimeImmutable;
use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\CartRepository;
use App\Repository\UserRepository;
use App\Repository\ProductRepository;
use App\Repository\CartProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/action')]
class ActionController extends AbstractController
{   
    #Products
    #[Route('/product/new', name: 'app_product_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProductRepository $productRepository): Response
    {
        if(!$this->isGranted('ROLE_SELLER')) {
            return $this->redirectToRoute('app_home');
        }
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setCreatedAt(new DateTimeImmutable('now'));
            $product->setUpdatedAt(new DateTimeImmutable('now'));
            $product->setSeller($this->getUser());
            $product->setQuantity($form->get('quantity')->getData());
            $product->setPublished(true);
            $productRepository->save($product, true);

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('content/product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/product/{id}', name: 'app_product_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        if($product->getSeller() !== $this->getUser()){
            return $this->redirectToRoute('app_home');
        }

        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $productRepository->remove($product, true);
        }

        return $this->redirectToRoute('app_profile', [
            'id'=>$this->getUser()->getId()
        ], Response::HTTP_SEE_OTHER);
    }
    #[Route('/product/edit/{id}', name: 'app_product_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        if($product->getSeller() !== $this->getUser()){
            return $this->redirectToRoute('app_home');
        }
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productRepository->save($product, true);

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('content/product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }
    #[Route('/product/{id}/{status}', name: 'app_product_status', methods: ['GET', 'POST'])]
    public function status(Request $request, Product $product, ProductRepository $productRepository, $status): Response
    {
        if ($this->isCsrfTokenValid('status'.$product->getId(), $request->request->get('_token'))) {
            $product->setPublished($status);
            $productRepository->save($product, true);
        }

        return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
    }

    
    #Change role to seller
    #[Route('/switch-seller', name: 'app_seller', methods: ['GET', 'POST'])]
    public function switchToSeller(Request $request, UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        $user->setRoles(['ROLE_SELLER']);
        $userRepository->save($user, true);

        return $this->redirectToRoute('app_profile', [
            'id'=>$this->getUser()->getId()
        ], Response::HTTP_SEE_OTHER);
    }

    # Validation of the cart
    #[Route('/cart/validate', name: 'app_cart_validate', methods: ['GET', 'POST'])]
    public function validateCart(Request $request, CartRepository $cartRepository, CartProductRepository $cartProductRepository, ProductRepository $productRepository): Response
    {
        $cart = $cartRepository->findCartByUser($this->getUser()->getId());
        $products = $cartProductRepository->findProductsByCart($cart->getId());

        foreach($products as $product){
            $newQuantity = $product->getCartProduct()->getQuantity() - $product->getProductQuantity();
            $productRepository->updateQuantity($product->getCartProduct()->getId(), $newQuantity);
        }
        $cartProductRepository->removeAllIncludingCart($cart->getId(), true);

        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }
}