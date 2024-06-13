<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class BookController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/book/create', name: 'app_book_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $book->setAddedBy($this->getUser());
            $em->persist($book);
            $em->flush();
            $this->addFlash('success', 'Le livre a bien été créée.');
            return $this->redirectToRoute('app_bibliotheque');
        }

        return $this->render('book/create.html.twig', [
            'form' => $form,
        ]);
    }
}
