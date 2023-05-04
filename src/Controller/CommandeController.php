<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Repository\ArticlesRepository;
use App\Repository\CommandeDetailsRepository;
use App\Repository\CommandeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

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
    public function historique(CommandeDetailsRepository $repoComD, ArticlesRepository $repoArticles, CommandeRepository $repoCommande, UserRepository $repoUser): Response
    {

        $com = $repoCommande->findAll();
        $art = $repoComD->findAll();

        return $this->render('commande/index.html.twig', [
            'detail' => $com,
            'art' => $art,
        ]);
    }
}
