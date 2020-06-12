<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Controller\APIAllocineController;

class MovieController extends AbstractController
{

    public function ajaxRandom(){
            $Api= new APIAllocineController;
            $resultat = $Api->callAPIRandom(mt_rand(15000, 16000));
            return $this->json($resultat);
}

       public function movieDetails()
    {
        // on a bien cliqué sur un film pour avoir les infos
        $apiAllocine = new APIAllocineController();

        $movie_search = $apiAllocine->callAPIPartner('BadBoys');
        $movie_details_search = $apiAllocine->callAPIPartner2(14012);
        // die;

        // Récup le titre
        $movie_title = $movie_search['feed']['movie']['0']['originalTitle'];
        // Récup l'année de production
        $movie_production_year = $movie_search['feed']['movie']['0']['productionYear'];
        // Réalisateur
        $movie_director = $movie_search['feed']['movie']['0']['castingShort']['directors'];
        // Acteurs
        $movie_actors = $movie_search['feed']['movie']['0']['castingShort']['actors'];
        // Note
        $movie_rating = intval($movie_search['feed']['movie']['0']['statistics']['userRating']);
        // Affiche
        $movie_poster = $movie_search['feed']['movie']['0']['poster']['href'];
        // Synopsis
        $movie_synopsis = $movie_details_search['movie']['synopsis'];
        //Nationalité
        $movie_nationality = $movie_details_search['movie']['nationality']['0']['$'];
        // Genres
        $movie_genre = $movie_details_search['movie']['genre']['0']['$']; // 1 SEUL !! VOIR POUR PLUSIEURS
        $new_genre = [];
        foreach($movie_details_search['movie']['genre'] as $genre){
            $new_genre[] = $genre['$'];
        }
        $movie_genre = implode(', ', $new_genre);
        // Bande-Annonce
        // $movie_trailer = $movie_details_search['movie']['trailer']['href'];
        // Durée
        $movie_runtime = ($movie_details_search['movie']['runtime'])/60;


        return $this->render('movie/movie_details.html.twig', [
            'title' => $movie_title,
            'year' => $movie_production_year,
            'director' => $movie_director,
            'actors' => $movie_actors,
            'rating' => $movie_rating,
            'poster_link' => $movie_poster,
            'synopsis' => $movie_synopsis,
            'nationality' => $movie_nationality,
            'genre' => $movie_genre,
            // 'trailer' => $movie_trailer,
            'runtime' => $movie_runtime,
        ]);
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

}
