<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'app_categorie')]
    public function index(CategorieRepository $categorieRepository): Response
    {
        $categories = $categorieRepository->findAll();

        return $this->render('categorie/index.html.twig', [
            'categories' => $categories
        ]);
    }

    #[Route('/categorie/new', name: 'new_categorie')]
    public function new(Request $request, EntityManagerInterface $em)
    {
        $categorie = new Categorie();

        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $categorie->setCreatedAt(new DateTimeImmutable());
            $em->persist($categorie);
            $em->flush();
            return $this->redirectToRoute('app_categorie');
        }

        return $this->render('categorie/new.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/categorie/{id}/edit', 'edit_categorie')]
    public function edit(Request $request, EntityManagerInterface $em, Categorie $categorie)
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $categorie->setCreatedAt(new DateTimeImmutable());
            $em->persist($categorie);
            $em->flush();
            return $this->redirectToRoute('app_categorie');
        }

        return $this->render('categorie/edit.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/categorie/{id}/delete', 'del_categorie')]
    public function delete(Request $request, EntityManagerInterface $em, Categorie $categorie)
    {
        $em->remove($categorie);
        $em->flush();
        return $this->redirectToRoute('app_categorie');
    }
}
