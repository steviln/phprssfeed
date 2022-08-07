<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;



class AjaxController extends AbstractController
{
    // Have not done a check if this is an AjaxRequest, but I would have if I had had more time. 

        /**
     * @Route("/ajax/getfeed/{order}/{field}", name="rssajax")
     */
    public function getfeed(string $order, string $field, Request $request)
    {
 
        // I am using dependency injection to make the relevant method testable by dependency injection
        // It is set up to be testable with PHPUnit


            $fetcher = \helpers\DIhelper::getFeedFetcherClass($order,$field);
            $content = $fetcher->fetchRSScontent();

            // should propably have added a try catch here

            return new JsonResponse([
                'success' => true,
                'data'    => $content 
            ]);

    }
}



?>