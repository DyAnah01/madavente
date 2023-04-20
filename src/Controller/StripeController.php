<?php

namespace App\Controller;

use App\Entity\Commande;
use Stripe;
use App\Repository\ArticlesRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeController extends AbstractController
{
    #[Route('/paiement/{idUser}', name: 'app_stripe')]
    public function index($idUser, SessionInterface $session, ArticlesRepository $repoArticle, EntityManagerInterface $manager, UserRepository $repoUser): Response
    {
        $panier = $session->get('cart', []);
        if (empty($panier)) {
            $this->addFlash("error", "Votre panier est vide");
            return $this->redirectToRoute('get_cart');
        }
        $commande = new Commande;
        $commande->setStatut('En attente');
        $commande->setToken(hash('sha256', random_bytes(32)));
        $user = $repoUser->find($idUser);
        $commande->setUser($user);
        $manager->persist($commande);
        $manager->flush();

        Stripe\Stripe::setApiKey($this->getParameter('stripeSecretKey'));
        // Création d'un nouveau paiement
        $info = [
            'mode' => 'payment',
            'success_url' => $this->generateUrl('commande_success', [
                'token'=> $commande->getToken()
            ], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('commande_cancel', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ];

        $art = $repoArticle->getAllArticles(array_keys($panier));

        foreach ($panier as $id => $quantite) {
            $commande->addArticle($art[$id]);
            $info['line_items'][] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $art[$id]->getTitre(),
                        'images' => [$art[$id]->getPhoto()]
                    ],
                    'unit_amount' => $art[$id]->getPrix() * 100
                ],
                'quantity' => $quantite,
            ];
        }
        $manager->persist($commande);
        $manager->flush();

        // création du checkout
        $checkout = \Stripe\Checkout\Session::create($info);
        // Renvoyer l'utilisateur chez stripe
        return $this->redirect($checkout->url);
    }
}
