<?php

namespace App\Controller;

use Stripe;
use App\Repository\ArticlesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeController extends AbstractController
{
    #[Route('/paiement', name: 'app_stripe')]
    public function index(SessionInterface $session, ArticlesRepository $repoArticle): Response
    {
        $panier = $session->get('cart', []);
        if (empty($panier)) {
            $this->addFlash("error", "Votre panier est vide");
            return $this->redirectToRoute('get_cart');
        }

        Stripe\Stripe::setApiKey($this->getParameter('stripeSecretKey'));
        // Création d'un nouveau paiement
        $info = [
            'mode' => 'payment',
            'success_url' => $this->generateUrl('commande_success', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('commande_cancel', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ];

        $produit = $repoArticle->getAllArticles(array_keys($panier));

        foreach ($panier as $ids => $quantite) {
            $info['line_items'][] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $produit[$ids]->getTitre(),
                        'images' => [$produit[$ids]->getPhoto()]
                    ],
                    'unit_amount' => $produit[$ids]->getPrix() * 100
                ],
                'quantity' => $quantite,
            ];
        }
        // création du checkout
        $checkout = \Stripe\Checkout\Session::create($info);
        // Renvoyer l'utilisateur chez stripe
        return $this->redirect($checkout->url);
    }
}
