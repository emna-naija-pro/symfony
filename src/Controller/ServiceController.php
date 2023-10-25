<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
class ServiceController extends AbstractController
{
    #[Route('/service/{name}', name: 'app_service')]
    //#[Route('/go-to-index', name: 'go_to_index')]
    public function index($name): Response
    {//$x='mohamed';
        return $this->render('service/index.html.twig', [
            'controller_name' => 'hello', 'name' =>$name// affichage  du nom apartir de la route 
             //$x  
        ]);
    }
/*
    public function goToIndex($name): RedirectResponse
    {
        // Redirigez vers la route existante 'app_service' dans HomeController
        return $this->redirectToRoute('app_service', ['name' => $name]);
    }*/
}
