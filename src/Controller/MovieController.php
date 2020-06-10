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

        $movie_details = $apiAllocine->callAPIPartner('avatar');
        
        return $this->render('movie/movie_find.html.twig', [
            'films' => $movie_details ?? [],
        ]);
    }

    public function findMovie()
    {

        // if(!empty($_POST)){
        //     // ...

        //     // formulaire ok, l'internaute a bien cherché un truc
        //     $apiAllocine = new APIAllocineController();

        //     $movie_found = $apiAllocine->callAPIPartner($safe['input_search_movie_by_user']);



        // }

        return $this->render('movie/movie_find.html.twig');
    }

}
