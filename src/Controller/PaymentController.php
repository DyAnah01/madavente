<?php

// namespace App\Controller;

// use Stripe\Stripe;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// class PaymentController extends AbstractController
// {
    // private $privateKey;

    // public function __construct()
    // {
    //     // Configuration de la clé API Stripe
    //     if ($_ENV["APP_ENV"] === 'dev') {
    //         $this->privateKey = Stripe::setApiKey($this->getParameter('stripeKey'));
    //     } else {
    //         $this->privateKey = $_ENV["STRIPE_SECRET"];
    //     }
    // }

    // #[Route('/payment', name: 'app_payment')]
    // public function index(): Response
    // {
    //     Stripe::setApiKey($this->getParameter('stripeSecretKey'));

    //     $info = [
    //         'mode' => 'payment',
    //         'success_url' => $this->generateUrl('commande_success'),
    //         'cancel_url' => $this->generateUrl('commande_cancel'),
    //     ];
    //     // return $this->render('payment/index.html.twig', [
    //     //     'controller_name' => 'PaymentController',
    //     // ]);
        
    // }
// }
