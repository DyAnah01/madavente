<?php

namespace App\Controller;

use App\Repository\UserRepository;
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
}
