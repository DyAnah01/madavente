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
        $search = $request->query->get('search');               
        $pagination = $paginator->paginate(
            $repoA->paginationQuery(),
            $request->query->get('page', 1),
            8
        );
        return $this->render('home/index.html.twig', [
            'pagination' => $pagination,
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
