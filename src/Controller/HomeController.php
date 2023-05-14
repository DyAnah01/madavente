<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use App\Repository\CategorieRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ArticlesRepository $repoA,CategorieRepository $repoCategorie , Request $request, PaginatorInterface $paginator): Response
    {
        // $aC = $repoA->getAllA();
        // dd($aC);
        // $articles = $repoArticle->findAll();
        // dd($articles);
        $pagination = $paginator->paginate(
            $repoA->paginationQuery(),
            $request->query->get('page', 1),
            8
        );
        // // set an array of custom parameters
        // $pagination->setCustomParameters([
        //     'align' => 'center', # center|right (for template: twitter_bootstrap_v4_pagination and foundation_v6_pagination)
        //     'size' => 'large', # small|large (for template: twitter_bootstrap_v4_pagination)
        //     'style' => 'bottom',
        //     'span_class' => 'whatever',
        // ]);
        // if($request->isMethod('post')){
        //     $categorie = $repoCategorie->findAll();
        //     $idCat = $request->request->get('articleCategorie');
        //     $art = $repoCategorie->getArticleWithIdCat($idCat);
        //     return $this->render("home/index.html.twig", [
        //         'filterArticles' => true,
        //         'categorie' => $categorie,
        //         'art' => $art

        //     ]);
        // }
        return $this->render('home/index.html.twig', [
            // 'filterArticles' => false,
            'pagination' => $pagination,
            // 'art' => $aC,
        ]);
    }
    
    #[Route('/A_propos', name: 'info')]
    public function info()
    {
        return $this->render('home/info.html.twig');
    }

    #[Route('/politique_de_confidentialite', name: 'rgpd')]
    public function afficheRgpd()
    {
        return $this->render('home/rgpd.html.twig');
    }

    #[Route('/mentions_legales', name: 'mentions_legales')]
    public function afficheMentions()
    {
        return $this->render('home/mentionsLegales.html.twig');
    }

    #[Route('/recherche', name: 'search')]
    public function FunctionName(Request $request)
    {
        $search = $request->query->get('search');
        return $this->render('nav.html.twig', [
            "search" => $search,
        ]);

    }
}
