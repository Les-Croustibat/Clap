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
        

        return $this->render('movie/movie_find.html.twig');
    }

    public function ajaxMovieCriteria(){ // Route OK
      
        if(!empty($_GET)){

            // Clean all data from forms
            $safe = $_GET;
            //$safe = array_map('trim', array_map('strip_tags', $_GET));

            // Call the API
            $apiAllocine = new APIAllocineController();

            // Get API data from the SEARCH/MOVIE endpoint
            $search_movies = $apiAllocine->callAPIPartner($safe['movie']);
            // $movie_year=$search_movies['feed']['movie']['productionYear'];
            // $movie_actors=$search_movies['feed']['movie']['castingShort']['actors'];
            // $movie_actors=$search_movies['feed']['movie']['castingShort']['directors'];
            
            // Get API data from the MOVIE/MOVIE endpoint
            $extra_movies= $apiAllocine->callAPIPartner2($safe['movie']);
            // $movie_genre=$extra_movies['movie']['genre'];
            // $movie_duration=$extra_movies['movie']['runtime'];
            // $movie_nationality=$extra_movies['movie']['nationality'];
            
            // Get API data from the PERSON/MOVIE endpoint
            $person_movie=$apiAllocine->callAPIPerson($safe['movie']);
            // $film_actor=$person_movie['person']['movie']['director'];
            // $film_director=$person_movie['person']['movie']['actor'];

            $all_API_results=[
                'search_movies' => $search_movies,
                'extra_movies'  => $extra_movies,
                'person_movie'  => $person_movie,
            ];


            // if($resultat['feed']['totalResults'] == 0){
            //     return $this->json(['status' => 'ko', 'error' => 'Désolé, cette personne est introuvable']);

            // }else{
            //     $retourJSON= $resultat['feed']['person'][0]['realName'];
            //     return $this->json(['status' => 'ok', 'result' =>$retourJSON]);
            // }

            return $this->json($all_API_results);
        }
    }


}
