<?php
namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\AbstractType;
use App\Form\AuthorType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;


use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthorController extends AbstractController{
#[Route('/list', name: 'list_author')]
    /*public function list(AuthorRepository $repo): Response
    {
        $authors = $repo->findAll();
        return $this->render('author/list.html.twig', [ 'authors' => $authors  
        ]);
    }
*/
 //oubien 

public function list(ManagerRegistry $doctrine): Response
    {
        $AuthorRepo = $doctrine->getRepository(Author::class);
        $authors = $AuthorRepo->findAll();//le repo sert a retourner des donnees de la base 
        return $this->render('author/list.html.twig', [ 'authors' => $authors  
        ]);
    }


    /*
    #[Route('/author/add', name: 'app_author_add')]
    public function add(ManagerRegistry $doctrine): Response
    {
        $author = new Author();
        $author->setUsername('emna');
        $author->setEmail('emna@example.com');
        $author->setNbBooks('5');

        $entityManager = $doctrine->getManager();
        $entityManager->persist($author);//fait l'ajout
        $entityManager->flush();//confirmer lajout

        return $this->redirectToRoute('list_author');
    }
*/

    #[Route('/author/add2', name: 'app_author_add2')]
public function add2(ManagerRegistry $doctrine,request $req): Response
{
    $author = new Author();
    $form=$this->createForm(AuthorType::class,$author);
    $form->handleRequest($req);//recup des donnees du form
    $entityManager = $doctrine->getManager();
    $AuthorRepo = $doctrine->getRepository(Author::class);
    $authors = $AuthorRepo->findAll();

    
    $form->add('add',SubmitType::class);
   
   
    if ($form->isSubmitted())
    {
    $entityManager->persist($author);//fait l'ajout
    $entityManager->flush();//confirmer lajout
    return $this->redirectToRoute('app_author_add2');
    }
    return $this->render('author/listadd.html.twig',['formAuth'=>$form->createView(), 'authors'=>$authors]);
}


#[Route('/author/deleteauthorwithzerobook', name: 'toto')]
public function deleteauthorwithzerobook( ManagerRegistry $doctrine): Response
    {   
        $repo=$doctrine->getRepository(Author::class);
        $em=$doctrine->getManager();
    
         // Supprimez l'auteur de la base de données
        


        // Trouvez tous les auteurs avec un nombre de livres nul
        $authors = $repo->findBy(['nb_books' => 0]);

        // Supprimez les auteurs trouvés
        foreach ($authors as $author) {
            $em->remove($author);
        }

        // Forcez l'exécution des modifications apportées à la base de données
        $em->flush();

        // Ajoutez un message flash à la session
        $this->addFlash('success', 'Auteurs sans livres supprimés avec succès.');

        // Redirigez vers la liste des auteurs ou une autre page appropriée
        return $this->redirectToRoute('list_author');
    }

/*
    #[Route('/authors-sorted-by-email', name:'authors_sorted_by_email')]
   
    public function authorsSortedByEmail(AuthorRepository $authorRepository): Response
    {
        $authors = $authorRepository->getAuthorsSortedByEmail2();

        // Vous pouvez renvoyer la liste triée d'auteurs à une vue Twig ou simplement la retourner en JSON, par exemple.
        return $this->render('author/authors_sorted_by_email.html.twig', [
            'authors' => $authors,
        ]);
    }
*/
    #[Route('/author/{id}', name: 'app_author')]
    
    public function index($name): Response
    {
        return $this->render('service/author.html.twig', [
            'name' => 'hello', 'name' =>$name// affichage  du nom apartir de la route 
            
        ]);
    }
    
    



// ...




#[Route('/author/edit/{id}', name: 'app_author_edit')]
public function edit( ManagerRegistry $doctrine,Request $request, int $id): Response
{   
    $entityManager = $doctrine->getManager();
    $author = $entityManager->getRepository(Author::class)->find($id);
    $form = $this->createForm(AuthorType::class, $author);
    $form->handleRequest($request);

    if ($form->isSubmitted() ) {
        $entityManager->flush();

        $this->addFlash('success', 'L\'auteur a été modifié avec succès.');

        return $this->redirectToRoute('list_author');
    }

    return $this->render('author/edit.html.twig', [
        'form' => $form->createView(),
        'author' => $author,
    ]);
}




#[Route('/author/delete/{id}', name: 'app_author_delete')]
public function delete(int $id , ManagerRegistry $doctrine): Response
{
   $repo=$doctrine->getRepository(Author::class);
   $em=$doctrine->getManager();
   $author = $repo->find($id);
    // Supprimez l'auteur de la base de données
    $em->remove($author);
    $em->flush();//pour confirmer 

    return $this->redirectToRoute('list_author');
}




}
?>