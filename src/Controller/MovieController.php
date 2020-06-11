<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Controller\APIAllocineController;

class MovieController extends AbstractController
{
    public function movieDetails()
    {


        return $this->render('movie/movie_details.html.twig');
    }
    public function findMovie()
    {
        
        // // Check forms

        // if(!empty($_GET)) {
            
        //     $safe= array_map('strip_tags', $_GET);
        //     $safe=array_map('trim', $safe);

        //     $apiAllocine = new APIAllocineController();
        //     $result_criteria_action = $apiAllocine->callAPIPartner($safe['action']);
        //     $result_criteria_year = $apiAllocine->callAPIPartner($safe['slider1']);
        //     $result_criteria_duration = $apiAllocine->callAPIPartner($safe['slider2']);
        //     $result_criteria_french = $apiAllocine->callAPIPartner($safe['french']);
        //     $result_criteria_american = $apiAllocine->callAPIPartner($safe['american']);
        //     $result_criteria_korean = $apiAllocine->callAPIPartner($safe['korean']);
        //     $result_criteria_spanish = $apiAllocine->callAPIPartner($safe['spanish']);
        //     $result_criteria_italian = $apiAllocine->callAPIPartner($safe['italian']);
        //     $result_criteria_other = $apiAllocine->callAPIPartner($safe['other']);
        //     $result_criteria_people = $apiAllocine->callAPIPartner($safe['film_actor_director']);

            
        // } else {
        //     return randomMovie();
        // }

        return $this->render('movie/movie_find.html.twig');
    }

    public function randomMovie()
    {
        
        // $apiAllocine = new APIAllocineController();
        // array_rand(array_flip($result_random_movie = $apiAllocine->callAPIPartner()), 1);

        return $this->render('movie/movie_find.html.twig');
    }
}
