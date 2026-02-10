<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;

final class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(UserInterface $user): Response
    {
        return $this->render('profil/index.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('/profil/edit', name: 'edit_profil')]
    public function edit(UserInterface $user, EntityManagerInterface $em) {
        return $this->render('profil/edit.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('/profil/delete', name: "delete_profil")]
    public function delete(UserInterface $user, EntityManagerInterface $em) {
        return $this->render('profil/delete.html.twig', [
            'user' => $user
        ]);
    }
}
