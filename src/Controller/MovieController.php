<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MovieController extends AbstractController
{

    
    public function ajaxMovieCriteria(){
        
        $apiTmdb = new callMovieCriteria();
        $affichage = $apiTmdb->callMovieCriteria();
        
        return $this->json($affichage);
        
    }
    
    public function findMovie()
    {
         
         return $this->render('movie/movie_find.html.twig');
    }

}
