<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Categorie;
use App\Repository\ArticlesRepository;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FiltrecategorieController extends AbstractController
{
    #[Route('/filtrecategorie', name: 'app_filtrecategorie')]
    public function index(CategorieRepository $categorieRepository): Response
    {
        return $this->render('filtrecategorie/index.html.twig', [
            'categorie' => $categorieRepository->findAll(),
        ]);
    }

    #[Route('/filtrecategoriearticle/{id}', name: 'app_filtrecategorie_article')]
    public function article_filtre(
        Categorie $categorie,
        ArticlesRepository $articlesRepository
    ): Response {
        // afficher tout les articles correspondant à cette catégorie
        $artCatFilter = $articlesRepository->findBy(['idCategorie' => $categorie]);
        return $this->render('filtrecategorie/showArticlesFilter.html.twig', [
            'categorie' => $artCatFilter,
        ]);
    }
}
