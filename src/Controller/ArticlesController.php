<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Form\ArticlesType;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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
    public function addArticles(ArticlesRepository $repoA, Request $request, EntityManagerInterface $manager, SluggerInterface $slugger)
    {
        // $articles = $repoA->findAll();
        $aarticle = new Articles;
        $form = $this->createForm(ArticlesType::class, $aarticle);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            // 
            $fichierImage = $form->get('images')->getData();
                // this condition is needed because the 'images' field is not required
                // so the png file must be processed only when a file is uploaded
            if($fichierImage){
                $originalFilename = pathinfo($fichierImage->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $nom = $safeFilename.'-'.uniqid().'.'.$fichierImage->guessExtension();
                // Move the file to the directory where brochures are stored
                try{
                    $fichierImage->move(
                        $this->getParameter('images_directory'),
                        $nom
                    );

                } catch(FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                // updates the 'brochureFilename' property to store the png file name
                // instead of its contents  
                $aarticle->setPhoto($nom);      

            }

            // 
            $manager->persist($aarticle);
            $manager->flush();
            $this->addFlash('success', "L'article N° " . $aarticle->getId() . " a bien été ajouté");
            return $this->redirectToRoute('add_articles');
        }
        return $this->render('articles/addArticles.html.twig', [
            // "articles" => $articles,
            "formArticles" => $form->createView(),
        ]);
    }

    #[Route('/admin/show/articles', name:"show_articles")]
    public function justShow_articles(ArticlesRepository $repoArticle)
    {
        $a = $repoArticle->findAll();
        return $this->render("articles/showArticles.html.twig",[
            "articles" => $a,
        ]);
    }

    #[Route('/articles/details/{id}', name:"detail_article")]
    public function detail_articles($id, ArticlesRepository $repoArticle)
    {
        $art = $repoArticle->find($id);
        return $this->render("articles/detail_articles.html.twig",[
            "article" => $art,
        ]);
    }

    #[Route('/admin/article/update/{id}', name:"update_article")]
    public function update_articles($id, ArticlesRepository $repoA, Request $request, EntityManagerInterface $manager)
    {
        $articles = $repoA->find($id);
        $form = $this->createForm(ArticlesType::class, $articles);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($articles);
            $manager->flush();

        $this->addFlash("success", "L'article N°" . $articles->getId(). " a bien été mis à jour");
        return $this->redirectToRoute("add_articles");
        }
        return $this->render("articles/update_articles.html.twig", [
            "formArticles" => $form->createView(),
            "articles" => $articles,
            "idA" => $articles->getId(),
        ]);

    }
    
    #[Route('/admin/article/supprimer/{id}', name: "delete_article")]
    public function deleteArticle(Articles $art , EntityManagerInterface $manager)
    {
        $idArt = $art->getId();
        $manager->remove($art);
        $manager->flush();
        $this->addFlash("success", "L'article N° $idArt a bien été supprimé");
        return $this->redirectToRoute("add_articles");
    }

}

