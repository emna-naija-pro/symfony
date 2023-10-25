<?php

namespace App\Controller;
use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }
    #[Route('/list/book', name: 'list_book')]

    public function listBook(ManagerRegistry $doctrine): Response
    {
        $BookRepo = $doctrine->getRepository(Book::class);
        $books = $BookRepo->findAll();//le repo sert a retourner des donnees de la base 
        
    foreach ($books as $book) {
        $book->formattedPublicationDate = $book->getPublicationDate()->format('Y-m-d H:i:s');
    }
        return $this->render('book/listBook.html.twig', [ 'books' => $books
        ]);
    }
/* ce code est  avec la requete cree manuellement avec query builder dans le repo book
    #[Route('/list/book', name: 'list_book')]

    public function listBook(BookRepository $b): Response
    {
        //$BookRepo = $doctrine->getRepository(Book::class);
        $books = $b->findAll2();//le repo sert a retourner des donnees de la base 
        
    foreach ($books as $book) {
        $book->formattedPublicationDate = $book->getPublicationDate()->format('Y-m-d H:i:s');
    }
        return $this->render('book/listBook.html.twig', [ 'books' => $books
        ]);
    }
    
    */


    /**
 * @Route("/search-books", name="search_books")
 */
#[Route('/search-books', name: 'search_books')]
public function searchBooks(Request $request, BookRepository $bookRepository): Response
{
    $searchTerm = $request->query->get('search');
    $books = $bookRepository->findByRef($searchTerm);

    return $this->render('book/search_results.html.twig', [
        'books' => $books,
    ]);
}
    #[Route('/book/add2', name: 'app_book_add2')]
    public function add2(ManagerRegistry $doctrine,Request $req): Response
    {
        $Book = new Book();
        $entityManager = $doctrine->getManager();
       
        $form=$this->createForm(BookType::class,$Book);
        $form->add('add',SubmitType::class);//ceci  est pour la reutilisation du formulaire dans modify ou autre
        $form->handleRequest($req);//recup des donnees du form
       
        if ($form->isSubmitted())
        {
            $author = $Book->getAuthor();

        // Incrémentation de l'attribut "nb_books" de l'entité "Author"
        $author->setNbBooks($author->getNbBooks() + 1);
  
        // Persistez l'entité "Author" mise à jour
        $entityManager->persist($author);

        $entityManager->flush();
        $entityManager->persist($Book);//fait l'ajout
        $entityManager->flush();//confirmer lajout
        return $this->redirectToRoute('list_book');
        }
        return $this->render('book/add.html.twig',['book'=>$form->createView()]);
    }


    #[Route('/list/published-books', name: 'list_published_books')]
    public function listPublishedBooks(ManagerRegistry $doctrine): Response
    {
        $bookRepo = $doctrine->getRepository(Book::class);
        $allBooks = $bookRepo->findAll();
        $publishedBooks = [];
    
        foreach ($allBooks as $book) {
            if ($book->isPublished()) {
                $publishedBooks[] = $book;
            }
        }
    
        return $this->render('book/listPublishedBooks.html.twig', [
            'publishedBooks' => $publishedBooks,
            'allBooks' => $allBooks, // Passer la liste complète des livres
        ]);

    }
    



#[Route('/book/edit/{ref}', name: 'appbook_edit')]
public function edit( ManagerRegistry $doctrine,Request $request, int $ref): Response
{   
    $entityManager = $doctrine->getManager();
    $book = $entityManager->getRepository(Book::class)->find($ref);
    $form = $this->createForm(BookType::class, $book);
    $form->handleRequest($request);

    if ($form->isSubmitted() ) {
        $entityManager->flush();

        $this->addFlash('success', 'book a été modifié avec succès.');

        return $this->redirectToRoute('list_book');
    }

    return $this->render('book/edit.html.twig', [
        'form' => $form->createView(),
        'book' => $book,
    ]);
}


#[Route('/book/delete/{ref}', name: 'deletebook')]
public function delete(int $ref , ManagerRegistry $doctrine): Response
{
   $repo=$doctrine->getRepository(Book::class);
   $em=$doctrine->getManager();
   $book= $repo->find($ref);
    // Supprimez l'auteur de la base de données
    $em->remove($book);
    $em->flush();//pour confirmer 

    return $this->redirectToRoute('list_published_books');
}
#[Route('/book/show/{ref}', name: 'showbook')]
public function showBookDetails(int $ref , ManagerRegistry $doctrine)
    {
        $repo=$doctrine->getRepository(Book::class);
        $em=$doctrine->getManager();
        $book= $repo->find($ref);
        if (!$book) {
            throw $this->createNotFoundException('Le livre n\'existe pas.');
        }

        return $this->render('book/bookDetails.html.twig', [
            'book' => $book,
        ]);
    }



}