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

#[Route('/auteur')]
class AuthorController extends AbstractController
{
    #[Route('/', name: 'app_authors')]
    public function index(ArtistRepository $artistRepository): Response
    {
        $authors = $artistRepository->findBy(['job' => 'Auteur']);
        return $this->render('author/index.html.twig', [
            'authors' => $authors,
        ]);
    }

    #[Route('/nouveau', name: 'app_author_new', methods: ['GET', 'POST'])]
    public function newForm(Request $request, EntityManagerInterface $entityManager): Response
    {
        $artist = new Artist();
        $artist->setJob('Auteur');
        $form = $this->createForm(ArtistType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($artist);
            $entityManager->flush();

            return $this->redirectToRoute('app_authors', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('author/new.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/modifier/{id}/', name: 'app_author_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function updateForm(Request $request, Artist $author, ArtistRepository $artistRepository, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArtistType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_authors', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('author/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/supprimer/{id}/', name: 'app_author_delete', requirements: ['id' => '\d+'])]
    public function delete(Artist $artist, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($artist);
        $entityManager->flush();

        return $this->redirectToRoute('app_authors');
    }
}
