<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Stripe;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class StripeController extends AbstractController
{
    private $privateKey;

    public function __construct()
    {
        // Configuration de la clé API Stripe
        if ($_ENV["APP_ENV"] === 'dev') {
            $this->privateKey = $_ENV["STRIPE_KEY"];
        } else {
            $this->privateKey = $_ENV["STRIPE_SECRET"];
        }
    }

    // /{infoCart}/{priceTotal}
    // $infoCart, $priceTotal, ArticlesRepository $repoArt
    #[Route('/profile/stripe', name: 'app_stripe')]
    public function index(): Response
    {
        // dd($infoCart);
        // die;
        // $Cart = $repoArt->find($infoCart);
        // $priceTotal = $repoArt->find($priceTotal);

        return $this->render('stripe/index.html.twig', [
            /* 
                Retourne le template twig "stripe/index.html.twig" 
                et passe la clé publique de Stripe comme variable 
            */
            'stripe_key' => $_ENV["STRIPE_KEY"],
            // 'infoCart' => $infoCart,
            // 'prixTotal' => $priceTotal,
        ]);
    }

    #[Route('/profile/stripe/create-charge', name: 'app_stripe_charge', methods: ['POST'])]
    public function createCharge(Request $request , SessionInterface $session, ArticlesRepository $article)
    {
        $panier = $session->get('cart', []);
        if(empty($panier)){
            $this->addFlash("error", "Votre panier est vide");
            return $this->redirectToRoute('get_cart');
        }





        Stripe\Stripe::setApiKey($_ENV["STRIPE_SECRET"]);
        // Création d'un nouveau paiement
        $info = [
            'mode' => 'payment',
            'success_url' => $this->generateUrl('commande_success'),
            'cancel_url' => $this->generateUrl('commande_cancel'),
        ];
        // Stripe\Charge::create([
        //     "amount" => 222 * 100, // Montant du paiement en cents
        //     "currency" => "eur", // Devise
        //     "source" => $request->request->get('stripeToken'), // Token de la carte bancaire
        //     "description" => "Binaryboxtuts Payment Test" // Description du paiement
        // ]);

        // // Ajout d'un message flash pour indiquer que le paiement a été effectué avec succès
        // $this->addFlash(
        //     'success',
        //     'Le paiement a bien été éffectué!'
        // );

        // Redirection vers la page principale après le paiement
        // return $this->redirectToRoute('app_stripe', [], Response::HTTP_SEE_OTHER);
    }
}
