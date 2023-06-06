<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\CommandeDetails;
use App\Entity\User;
use App\Repository\ArticlesRepository;
use App\Repository\CommandeDetailsRepository;
use App\Repository\CommandeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
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


        // Gestion de stock
        $co = $repoCommande->findOneBy(['token' => $commande->getToken()]);
        foreach ($co->getCommandeDetails() as $valueDetail) {
            $quantityArticle = $valueDetail->getQuantity();
            $stock = $valueDetail->getArticles()->getStock();
            $stock = $stock - $quantityArticle;
            $valueDetail->getArticles()->setStock($stock);
        }


        $manager->persist($commande);
        $manager->flush();

        return $this->render('payment/success.html.twig');
    }

    #[Route('/commande_cancel', name: 'commande_cancel')]
    public function cancel(): Response
    {
        return $this->render('payment/cancel.html.twig', []);
    }

    // Affiche la liste de commande pour Admin
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/historiqueCommande', name: 'historique_commande_admin')]
    public function historique(CommandeDetailsRepository $repoComD, CommandeRepository $repoCommande): Response
    {
        $com = $repoCommande->findAll();

        return $this->render('commande/listOrderAdmin.html.twig', [
            'detail' => $com,
        ]);
    }

    // Affiche la liste de commande détaillé pour Admin
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/detail/historique/commande/{id}', name: 'details_historique_commande_admin')]
    public function detailOrderAdmin($id, CommandeDetailsRepository $repoComD, CommandeRepository $repoCommande): Response
    {
        $com = $repoCommande->findOneBy(['id' => $id]);
        return $this->render('commande/commandeAdmin.html.twig', [
            'detailCommande' => $com,
        ]);
    }

    // Set statut commande user "Livré" si remove_commande_user
    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin/commande/livree/{token}', name: 'commande_livré')]
    public function commandeLivré($token, EntityManagerInterface $em, CommandeRepository $rC, ArticlesRepository $rA)
    {
        $c = $rC->findOneBy(['token' => $token]);
        if ($c == null) {
            throw new NotFoundHttpException;
        }
        if ($c->getStatut() == 'Annulé') {
            throw new BadRequestException();
        }
        if ($c->getStatut() == 'Payé') {
            $c->setStatut('Livré');
        }
        $em->persist($c);
        $em->flush();

        $this->addFlash("success", "La commande a bien été marqué comme livrée");
        return $this->redirectToRoute("historique_commande_admin");
    }


    // Affiche la liste de commande pour User
    #[IsGranted('ROLE_USER')]
    #[Route('/profile/historique/commandes', name: 'list_commande_user')]
    public function listCommandeUser(CommandeDetailsRepository $repoComD, UserRepository $repoUser, CommandeRepository $repoCommande, EntityManagerInterface $em): Response
    {
        $com = $this->getUser()->getCommandes();
        return $this->render('commande/listOrderUser.html.twig', [
            'commandes' => $com,
        ]);
    }

    // Affiche la liste de commande détaillé User
    #[IsGranted('ROLE_USER')]
    #[Route('/profile/details/commandes/{id}', name: 'detail_historique_commande_user')]
    public function detailCommandeUser($id, CommandeDetailsRepository $repoComD, UserRepository $repoUser, CommandeRepository $repoCommande, EntityManagerInterface $em): Response
    {
        $com = $repoCommande->find($id);
        return $this->render('commande/commandeUser.html.twig', [
            'commande' => $com,
        ]);
    }

    // Set statut commande user "annulé" si remove_commande_user
    #[IsGranted('ROLE_USER')]
    #[Route('/profile/commande/delete/{token}', name: 'remove_commande_user')]
    public function removeCommande($token, EntityManagerInterface $em, CommandeRepository $repoC)
    {
        $commande = $repoC->findOneBy(['token' => $token]);
        if ($commande == null) {
            throw new NotFoundHttpException;
        }
        // user can't remove his order when it's delivered
        if ($commande->getStatut() == "Livrée") {
            throw new BadRequestException();
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
