<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ArticlesRepository $repoArticle): Response
    {
    $articles = $repoArticle->findAll();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            "articles"=>$articles,
        ]);
    }
}
