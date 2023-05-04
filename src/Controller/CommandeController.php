<?php

namespace App\Controller;

use App\Repository\CommandeDetailsRepository;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    #[Route('/commande_success/{token}', name: 'commande_success')]
    public function success($token, SessionInterface $session, EntityManagerInterface $manager, CommandeRepository $repoCommande): Response
    {

        $session->set('cart', []);
        $commande = $repoCommande->findOneBy([
            'token' => $token
        ]);

        if (empty($commande)) {
            throw new BadRequestHttpException;
        }
        $commande->setStatut("Payé");
        $manager->persist($commande);
        $manager->flush();

        return $this->render('payment/success.html.twig');
    }

    #[Route('/commande_cancel', name: 'commande_cancel')]
    public function cancel(): Response
    {
        return $this->render('payment/cancel.html.twig', []);
    }

    #[Route('/admin/historiqueCommande', name: 'historique_commande_admin')]
    public function historique(CommandeDetailsRepository $repoComD, CommandeRepository $repoCommande): Response
    {
        $com = $repoCommande->findAll();
        $art = $repoComD->findAll();

        return $this->render('commande/index.html.twig', [
            'detail' => $com,
            'art' => $art,
        ]);
    }
}
