<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Controller\APIAllocineController;

class MovieController extends AbstractController
{
    public function findMovie()
    {
        $apiAllocine = new APIAllocineController();
        $random = rand(1, 61498);
        
        $movie_details = $apiAllocine->callAPIPartner($random);

        $movie_title = $movie_details['movie']['originalTitle'];

        return $this->render('movie/movie_find.html.twig', [
            'titre' => $movie_title ?? [],
        ]);
    }

    public function ajaxRandom(){
            $Api= new APIAllocineController;
            $resultat = $Api->callAPIPartner(mt_rand(15000, 16000));
            return $this->json($resultat);

    }

}
