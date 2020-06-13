<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Controller\TmdbController;

class MovieController extends AbstractController
{

    public function findMovie()
    {
        // $apiTmdb = new callMovieCriteria();
        // $affichage = $apiTmdb->callMovieCriteria();
        return $this->render('movie/movie_find.html.twig');
    }

    public function ajaxMovieCriteria(){
      
        $apiTmdb = new callMovieCriteria();
        $affichage = $apiTmdb->callMovieCriteria();
        return $this->json($affichage);
        
    }


}
