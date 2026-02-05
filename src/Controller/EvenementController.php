<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use function Symfony\Component\Clock\now;

final class EvenementController extends AbstractController
{
    #[Route('/evenement', name: 'app_evenement')]
    public function index(EvenementRepository $evenementRepository): Response
    {
        $events = $evenementRepository->findAll();
        return $this->render('evenement/index.html.twig', [
            'events' => $events
        ]);
    }

    #[Route('/evenement/new', 'new_event')]
    public function new(Request $request, EntityManagerInterface $em)
    {
        $evenement = new Evenement();

        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $evenement->setCreatedAt(new DateTimeImmutable());
            $em->persist($evenement);
            $em->flush();
            return $this->redirectToRoute('app_evenement');
        }

        return $this->render('evenement/new.html.twig', [
            'formevent' => $form
        ]);
    }
}
