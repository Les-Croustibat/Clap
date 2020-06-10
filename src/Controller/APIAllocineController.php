<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class APIAllocineController extends AbstractController
{
    
    public function callAPI()
    {

        // DO NOT FORGET !!! no render just a return of data
        return $this->render('api_allocine/index.html.twig', [
            'controller_name' => 'APIAllocineController',
        ]);
    }
    
}
