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
        $random = rand(1, 61498);
        
        $movie_details = $apiAllocine->callAPIPartner($random);
        dump($movie_details);

        //$movie_title = $movie_details['movie']['originalTitle'];
        //$movie_link = $movie_details['movie']['link']['0']['href'];
        
        if(!empty($_POST)){
            if(isset($_POST['action']) && $_POST['action'] === 'hasard') {
                $movie_title = $movie_details['movie']['originalTitle'];
            }
        }

        return $this->render('movie/movie_find.html.twig', [
            'titre' => $movie_title ?? [],
            // 'link' => $movie_link ?? [],
        ]);
    }

    // No result: fonction ou solution pour emêcher ça (voir taille du max de rand)
    // Ajax
    // Créer une fonction qui trouve le nombre le plus élevé
    //Si error i-- return i*
    //Faire apparaître la balise div quand on appuie sur le bouton display hidden et block

}
