<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Controller\APIAllocineController;

class MovieController extends AbstractController
{

    public function ajaxRandom(){
            
    }

       public function movieDetails()
    {
       
    }

    public function findMovie()
    {
<<<<<<< HEAD
        
=======
        // Call the API controller
        $apiTMDB = new APITmdbController();

        // Build the results in an array
        $year_selected=explode(',', $_GET['primary_release_date']);
        $genre_selected= implode(',', $_GET['with_genres']);

        $searchedYear1=$year_selected[0];
        $searchedYear2=$year_selected[1];

        // Call the API method & retrieve results
        $findmovies=$apiTMDB->callTMDBAPIDiscover($searchedYear1, $searchedYear2, $genre_selected);
        $movie_results=$findmovies['results'];
        dd($movie_results);
    
        return $this->render('movie/movie_find.html.twig',[

            'movie_results'   => $movie_results ?? [],

        ]);
>>>>>>> 66de0957953401ddbc456307561d985f8d052039
    }

    public function ajaxMovieCriteria(){ // Route OK
      
    }


}
