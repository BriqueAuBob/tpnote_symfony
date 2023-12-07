<?php

namespace App\Controller;

use App\Repository\ArtistRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Artist;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ArtistType;

#[Route('/dessinateur')]
class DrawerController extends AbstractController
{
    #[Route('/', name: 'app_drawers')]
    public function index(ArtistRepository $artistRepository): Response
    {
        $drawers = $artistRepository->findBy(['job' => 'Dessinateur']);
        return $this->render('drawer/index.html.twig', [
            'drawers' => $drawers,
        ]);
    }

    #[Route('/nouveau', name: 'app_drawer_new', methods: ['GET', 'POST'])]
    public function newForm(Request $request, EntityManagerInterface $entityManager): Response
    {
        $artist = new Artist();
        $artist->setJob('Dessinateur');
        $form = $this->createForm(ArtistType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($artist);
            $entityManager->flush();

            return $this->redirectToRoute('app_drawers', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('drawer/new.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/modifier/{id}/', name: 'app_drawer_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function updateForm(Request $request, Artist $drawer, ArtistRepository $artistRepository, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArtistType::class, $drawer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_drawers', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('drawer/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/supprimer/{id}/', name: 'app_drawer_delete', requirements: ['id' => '\d+'])]
    public function delete(Artist $artist, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($artist);
        $entityManager->flush();

        return $this->redirectToRoute('app_drawers');
    }
}
