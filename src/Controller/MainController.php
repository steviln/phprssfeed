<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

// To make the project relativley simple, I have used no frontend framework. 

class MainController extends AbstractController
{


    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->Render('index.html.twig');
    }


}



?>