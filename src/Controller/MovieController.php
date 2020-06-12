<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Controller\APIAllocineController;

class MovieController extends AbstractController
{

    public function ajaxRandom(){
            $Api= new APIAllocineController;
            $resultat = $Api->callAPIRandom(mt_rand(15000, 16000));
            return $this->json($resultat);

    }

}
