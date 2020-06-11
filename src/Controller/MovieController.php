<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Controller\APIAllocineController;

class MovieController extends AbstractController
{
    public function movieDetails()
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
        if(!empty($_POST)){
            $safe = array_map('trim', array_map('strip_tags', $_POST));

            $Api= new APIAllocineController;
            $resultat = $Api->movieDetails($safe['movie'],'person');

            return $this->json($resultat);
        }
    }

}
