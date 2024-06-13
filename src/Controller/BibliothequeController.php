<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BibliothequeController extends AbstractController
{
    #[Route('/bibliotheque', name: 'app_bibliotheque')]
    public function index(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findByAddedBy($this->getUser());
        return $this->render('bibliotheque/index.html.twig', [
            'books' => $books,
        ]);
    }
}
