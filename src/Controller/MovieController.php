<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Controller\APIAllocineController;

class MovieController extends AbstractController
{
    public function movieDetails()
    {
        // on a bien cliqué sur un film pour avoir les infos
        $apiAllocine = new APIAllocineController();

        $movie_details = $apiAllocine->callAPIPartner(143692);
        // in_array
        dump($movie_details); 
        die;
        //$movie_title = $movie_details['feed']['movie']['0']['originalTitle'];
        
        return $this->render('movie/movie_find.html.twig', [
            'titre' => $movie_title ?? [],
        ]);
    }

}
