<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


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