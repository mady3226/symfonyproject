<?php

namespace App\Controller;




use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{



    public function __construct()
    {
    }

    public function index(): Response
    {
        //return $this->render('Algorithme/algorithmecalcul.html.twig');
        //return new Response('Hellowork !');
        return $this->redirectToRoute('algorithmecalcul');

    }

}
