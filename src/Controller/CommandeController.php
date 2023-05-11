<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\CommandeDetails;
use App\Entity\User;
use App\Repository\CommandeDetailsRepository;
use App\Repository\CommandeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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

        return $this->render('commande/index.html.twig', [
            'detail' => $com,
        ]);
    }

    #[Route('/admin/detail/historique/ommande', name: 'details_historique_commande_admin')]
    public function detailOrderAdmin(CommandeDetailsRepository $repoComD, CommandeRepository $repoCommande): Response
    {
        $com = $repoCommande->findAll();

        return $this->render('commande/index.html.twig', [
            'detail' => $com,
        ]);
    }

    // Affiche la liste de commande
    #[Route('/profile/historique/commandes', name: 'list_commande_user')]
    public function listCommandeUser(CommandeDetailsRepository $repoComD, UserRepository $repoUser, CommandeRepository $repoCommande, EntityManagerInterface $em): Response
    {
        $com = $this->getUser()->getCommandes();
        return $this->render('commande/listOrderUser.html.twig', [
            'commandes' => $com,
        ]);
    }

    // Affiche la liste de commande détaillé
    #[Route('/profile/details/commandes', name: 'detail_historique_commande_user')]
    public function detailCommandeUser(CommandeDetailsRepository $repoComD, UserRepository $repoUser, CommandeRepository $repoCommande, EntityManagerInterface $em): Response
    {
        $com = $this->getUser()->getCommandes();
        return $this->render('commande/commandeUser.html.twig', [
            'commandes' => $com,
        ]);
    }

    // Set statut commande user "annulé" si remove_commande_user
    #[Route('/profile/commande/delete/{token}', name: 'remove_commande_user')]
    public function removeCommande($token, EntityManagerInterface $em, CommandeRepository $repoC)
    {
        $commande = $repoC->findOneBy(['token' => $token]);
        if( $commande == null){
           throw new NotFoundHttpException;
        }
        if ($commande->getStatut() == 'Payé') {
            $commande->setStatut('Annulé');
        }
        $em->persist($commande);
        $em->flush();

        $this->addFlash("success", "La commande a bien été annulé");
        return $this->redirectToRoute("list_commande_user");
    }
}
