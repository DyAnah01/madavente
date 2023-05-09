<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/profile/mon_panier', name: 'get_cart')]
    public function index(CartService $cartService): Response
    {
        return $this->render('cart/index.html.twig', [
            'cart' => $cartService->getTotal(),
        ]);
    }

    #[Route('/profile/add/cart/{id}', name: 'post_cart')]
    public function add(CartService $cartService, Articles $articles): RedirectResponse
    {
        // *************************************************************************** 
        $cartService->addCart($articles->getId());
        $this->addFlash('success', 'Ajouté au panier');
        return $this->redirectToRoute('home');
    }

    #[Route('/profile/add/another_cart/{id}', name: 'post_cart_another')]
    public function addAnother(CartService $cartService, Articles $articles): RedirectResponse
    {
        $cartService->addCart($articles->getId());

        return $this->redirectToRoute('get_cart');
    }

    #[Route('/profile/delete/cart/{id}', name: 'delete_cart')]
    public function deleteCartById($id,CartService $cartService): RedirectResponse
    {
        $cartService->deleteCart($id);

        return $this->redirectToRoute('get_cart');
    }

    #[Route('/profile/delete/all/cart', name: 'delete_all_cart')]
    public function delete(CartService $cartService): RedirectResponse
    {
        $cartService->deleteAllCart();

        return $this->redirectToRoute('home');
    }
    // deleteCart()

    #[Route('/profile/decrease/cart/{id}', name: 'decrease_cart')]
    public function decrease($id,CartService $cartService): RedirectResponse
    {
        $cartService->decrease($id);

        return $this->redirectToRoute('get_cart');
    }

}
