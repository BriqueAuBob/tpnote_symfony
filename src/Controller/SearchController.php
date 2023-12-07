<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/recherche')]
class SearchController extends AbstractController
{
    #[Route('/', name: 'app_search')]
    public function index(): Response
    {
        return $this->render('search/index.html.twig');
    }


    #[Route('/resultat', name: 'app_search_show', methods: ['POST'])]
    public function show(Request $request, BookRepository $bookRepository): Response
    {
        $books = $bookRepository->search($request->request->get('search'));
        return $this->render('search/show.html.twig', [
            'search' => $request->request->get('search'),
            'books' => $books,
        ]);
    }
}
