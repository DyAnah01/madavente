<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name:'home')]
    public function index(ArticlesRepository $repoArticle): Response
    {
    $articles = $repoArticle->findAll();
    // dd($articles);
        return $this->render('home/index.html.twig', [
            "articles"=>$articles,
        ]);
    }
    
    #[Route('/politique_de_confidentialite', name:'rgpd')]
    public function afficheRgpd()
    {
        return $this->render('home/rgpd.html.twig');
    }

    #[Route('/mentions_legales', name:'mentions_legales')]
    public function afficheMentions()
    {
        return $this->render('home/mentionsLegales.html.twig');
    }
}
