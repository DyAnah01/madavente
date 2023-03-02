<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    #[Route('admin/categorie', name: 'app_categorie')]
    public function index(CategorieRepository $repoCat, Request $request, EntityManagerInterface $manager): Response
    {
        $categorie = $repoCat->findAll();

        $cat = new Categorie;
        $form = $this->createForm(CategorieType::class, $cat);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($cat);
            $manager->flush();
            $this->addFlash('success', 'La catégorie n° '.$cat->getId().' a bien été ajoutée');
            return $this->redirectToRoute('app_categorie');
        }

        return $this->render('categorie/index.html.twig', [
            'categorie'=> $categorie,
            'formCat' => $form->createView(),
        ]);
    }
    #[Route('admin/categorie/update/{id}', name: "update_categorie")]
    public function cat_update($id, CategorieRepository $repoC, Request $request, EntityManagerInterface $manager)
    {
        $categorie = $repoC->find($id);
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($categorie);
            $manager->flush();

            return $this->redirectToRoute('app_categorie');
        }

        return $this->render('categorie/updateCategorie.html.twig',[
            'formCategorie' => $form->createView(),
            'categorie' => $categorie,
        ]);
    }

    #[Route('admin/categorie/delete/{id}', name:'supprimer_categorie')]
    public function agences_delete(Categorie $categorie, EntityManagerInterface $manager)
    {
        $idCategorie = $categorie->getId();
        $manager->remove($categorie);
        $manager->flush();

        $this->addFlash("success", "La catégorie N° $idCategorie a été supprimé");
        return $this->redirectToRoute("app_categorie");

    }


}
