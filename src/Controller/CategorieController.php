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
            $this->addFlash('success', 'La catégorie n° '.$cat->getId().'a bien été ajoutée');
            return $this->redirectToRoute('app_categorie');
        }

        return $this->render('categorie/index.html.twig', [
            'categorie'=> $categorie,
            'formCat' => $form->createView(),
        ]);
    }
}
