<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    #[Route('admin/user/delete/{id}', name:'delete_user')]
    public function deleteUser(User $user, EntityManagerInterface $manager)
    {
        $idUser = $user->getId();
        $manager->remove($user);
        $manager->flush();
        $this->addFlash("success","Le user N° $idUser a bien été suppimé");
        return $this->redirectToRoute("app_user");
    }

}
