<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Form\ArticlesType;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{
    #[Route('/articles', name: 'app_articles')]
    public function index(): Response
    {
        return $this->render('articles/index.html.twig', [
            'controller_name' => 'ArticlesController',
        ]);
    }


    #[Route('/admin/add/articles', name: 'add_articles')]
    public function addArticles(ArticlesRepository $repoA, Request $request, EntityManagerInterface $manager)
    {
        $articles = $repoA->findAll();
        $a = new Articles;
        $form = $this->createForm(ArticlesType::class, $a);
        $form->handleRequest($request);

        

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($a);
            $manager->flush();
            $this->addFlash('success', "L'article N° " . $a->getId() . " a bien été ajouté");
            return $this->redirectToRoute('add_articles');
        }
        return $this->render('articles/addShowArticles.html.twig', [
            "articles" => $articles,
            "formArticles" => $form->createView(),
        ]);
    }
}
