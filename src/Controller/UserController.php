<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/admin/list/user', name: 'app_user')]
    public function index(UserRepository $repoUser): Response
    {
        $user = $repoUser->findAll();

        return $this->render('user/index.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('admin/user/delete/{id}', name: 'delete_user')]
    public function deleteUser(User $user, EntityManagerInterface $manager)
    {
        $idUser = $user->getId();
        $manager->remove($user);
        $manager->flush();
        $this->addFlash("success", "Le user N° $idUser a bien été suppimé");
        return $this->redirectToRoute("app_user");
    }

    #[Route('profile/Information_personnelle', name: 'info_user')]
    public function showInfoUser()
    {
        $user = $this->getUser();
        return $this->render('user/infoForUser.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/profile/info/update/{id}', name: "update_info_user")]
    public function updateInfoUserByHimself($id, UserRepository $repoUser, Request $request, EntityManagerInterface $em)
    {
        $user = $repoUser->find($id);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($user);
            $em->flush();

            $this->addFlash("success", "Vos informations ont bien été mis à jour");
            return $this->redirectToRoute("info_user");
        }
        return $this->render("user/updateInfoForUser.html.twig", [
            "formUser" => $form->createView(),
            "user" => $user,
        ]);
    }
}
