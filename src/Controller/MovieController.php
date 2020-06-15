<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Controller\APIAllocineController;
use App\Controller\APITmdbController;

class MovieController extends AbstractController
{

    public function ajaxRandom()
    {
       
        $Api = new APITmdbController();
        $resultat = $Api->callTMDBAPIRandom(mt_rand(1, 100));

        if(isset($resultat['id']) &&  !empty($resultat['id'])){
            $resultat['link_custom'] = $this->generateUrl('movie_details', ['id' => $resultat['id']]);
        }
        return $this->json($resultat);
    }

    public function movieDetails($id)
    {
        // on a bien cliqué sur un film pour avoir les infos
        $apiTMDB = new APITmdbController();

        $movie_search = $apiTMDB->callTMDBAPIMovieDetails($id);
        // dd($movie_search);

        // Récup le titre
        $movie_title = $movie_search['original_title'];
        // $movie_title = $movie_search['feed']['movie']['0']['originalTitle'];
        // // Récup l'année de production
        $movie_production_year = $movie_search['release_date'];
        // // Réalisateur
        // $movie_director = $movie_search['feed']['movie']['0']['castingShort']['directors'];
        // // Acteurs
        // $movie_actors = $movie_search['feed']['movie']['0']['castingShort']['actors'];
        // // Note
        $movie_rating = intval($movie_search['vote_average']);
        // // Affiche
        $movie_poster = $movie_search['poster_path'];
        // // Synopsis
        $movie_synopsis = $movie_search['overview'];
        // //Nationalité
        $movie_nationality = $movie_search['production_countries']['0']['iso_3166_1'];
        // // Genres
        $movie_genre = $movie_search['genres'];
        $new_genre = [];
        foreach ($movie_search['genres'] as $genre) {
            $new_genre[] = $genre['name'];
        }
        $movie_genre = implode(', ', $new_genre);
        // // Bande-Annonce
        // // $movie_trailer = $movie_details_search['movie']['trailer']['href'];
        // // Durée
        $movie_runtime = ($movie_search['runtime']);
        $movie_id = $movie_search['id'];


        return $this->render(
            'movie/movie_details.html.twig',
            [
                'original_title' => $movie_title,
                'release_date' => $movie_production_year,
                //     'director' => $movie_director,
                //     'actors' => $movie_actors,
                'rating' => $movie_rating,
                'poster_path' => $movie_poster,
                'synopsis' => $movie_synopsis,
                'nationality' => $movie_nationality,
                'genre' => $movie_genre,
                //     // 'trailer' => $movie_trailer,
                'runtime' => $movie_runtime,
                'movie_id' => $movie_id,
                'movie_results'   => $movie_results ?? [],
            ]
        );
    }

    public function findMovie()
    {
        // Call the API controller
        $apiTMDB = new APITmdbController();

        if (isset($_GET['with_genres'])) {
            $genre_selected = $_GET['with_genres'];
            $movie_genres = [];
            foreach ($_GET['with_genres'] as $chooseGenre) {
                $movie_genres[] = $chooseGenre;
            }
            $genre_selected = implode(', ', $movie_genres);
            
            // Call the API method & retrieve results
            // $searchedGenre = explode(', ', $genre_selected);
            $findmovies = $apiTMDB->callTMDBAPIDiscover($chooseGenre);
            $movie_results = $findmovies['results'];
            
        } else {
            echo 'Vous navez pas coche de case';
        }

        // Build the results in an array
        // $year_selected = explode(',', $_GET['primary_release_date']);
        // $genre_selected = implode(',', $_GET['with_genres']);

        // $searchedYear1=$year_selected[0];
        // $searchedYear2=$year_selected[1];


        return $this->render('movie/movie_find.html.twig', [

            'movie_results'   => $movie_results ?? [],
            // 'with_genres'     => $genre_selected ?? [],

        ]);
    }

    public function ajaxMovieCriteria()
    { // Route OK

        if (!empty($_GET)) {

            // Clean all data from forms
            // $safe = $_GET;
            $safe = array_map('trim', array_map('strip_tags', $_GET));

            // Call the API
            $apiTMDB = new APITmdbController();

            // Get API data from the SEARCH/MOVIE endpoint
            // $search_movies = $apiTMDB->callTMDBAPIMovie($safe['title']);
            // $movie_year=$search_movies['feed']['movie']['productionYear'];
            // $movie_actors=$search_movies['feed']['movie']['castingShort']['actors'];
            // $movie_actors=$search_movies['feed']['movie']['castingShort']['directors'];

            // // Get API data from the MOVIE/MOVIE endpoint
            // $extra_movies= $apiTMDB->callTMDBAPIMovieDetails($safe['title']);
            // // $movie_genre=$extra_movies['movie']['genre'];
            // // $movie_duration=$extra_movies['movie']['runtime'];
            // // $movie_nationality=$extra_movies['movie']['nationality'];

            // // Get API data from the PERSON/MOVIE endpoint
            // $person_movie=$apiTMDB->callTMDBAPIPeople($safe['name']);
            // // $film_actor=$person_movie['person']['movie']['director'];
            // // $film_director=$person_movie['person']['movie']['actor'];

            $findmovie = $apiTMDB->callTMDBAPIDiscover($safe['original_title']);


            // $all_API_results=[
            //     'extra_movies'  => $extra_movies,
            //     'person_movie'  => $person_movie,
            // ];


            // if($resultat['feed']['totalResults'] == 0){
            //     return $this->json(['status' => 'ko', 'error' => 'Désolé, cette personne est introuvable']);

            // }else{
            //     $retourJSON= $resultat['feed']['person'][0]['realName'];
            //     return $this->json(['status' => 'ok', 'result' =>$retourJSON]);
            // }

            return $this->$findmovie;
        }
    }
}
