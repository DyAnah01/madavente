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
    #[Route('/mon_panier', name: 'get_cart')]
    public function index(CartService $cartService): Response
    {
        // dd($cartService->getTotal());
        return $this->render('cart/index.html.twig', [
            'cart' => $cartService->getTotal(),
        ]);
    }

    #[Route('/add/cart/{id}', name: 'post_cart')]
    public function add(CartService $cartService, Articles $articles): RedirectResponse
    {
        $cartService->addCart($articles->getId());

        return $this->redirectToRoute('get_cart');
    }

    #[Route('/delete/cart/{id}', name: 'delete_cart')]
    public function deleteCartById($id,CartService $cartService): RedirectResponse
    {
        $cartService->deleteCart($id);

        return $this->redirectToRoute('get_cart');
    }

    #[Route('/delete/all/cart', name: 'delete_all_cart')]
    public function delete(CartService $cartService): RedirectResponse
    {
        $cartService->deleteAllCart();

        return $this->redirectToRoute('home');
    }
    // deleteCart()

    #[Route('/decrease/cart/{id}', name: 'decrease_cart')]
    public function decrease($id,CartService $cartService): RedirectResponse
    {
        $cartService->decrease($id);

        return $this->redirectToRoute('get_cart');
    }

}
