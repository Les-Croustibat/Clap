<?php

namespace App\Controller;

use App\Controller\APIAllocineController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    public function viewedRated()
    {
        $apiTMDB=new APITmdbController();
        $topRated = $apiTMDB->calltopRated();
        $mostViewed = $apiTMDB->callmostViewed();
        $most_movies_viewed = [];

        // ajoute une ligne à mon tableau
        foreach($mostViewed['results'] as $key => $movie){

            $most_movies_viewed[$key] = $movie;
            
            $trailer = $apiTMDB->callTMDBAPIMovieTrailer($movie['id']);
            if(!empty($trailer['results'])){

                $found_trailer = $trailer['results'][0];
                
                if(!empty($found_trailer)){
                    // ajoute dans mon tableau la ligne current_trailer => video
                    $most_movies_viewed[$key]['current_trailer'] = 'http://youtu.be/'.$found_trailer['key'];
                }
            }
            
        }


        $most_movies_rated = [];
        foreach($topRated['results'] as $movie){
            if($movie['vote_count'] < 20 ){
                $most_movies_rated[] = $movie;

            }
        }
        
        return $this->render('user/user_space.html.twig',[
            'topRated' => $most_movies_rated,
            'mostViewed' => $most_movies_viewed,
        ]);
    }

}


