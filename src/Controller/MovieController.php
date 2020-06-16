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
        $resultat = $Api->callTMDBAPIRandom(mt_rand(1,500));

        if(isset($resultat['id']) &&  !empty($resultat['id'])){

            $resultat['link_custom'] = $this->generateUrl('movie_details', ['id' => $resultat['id']]);

            return $this->json($resultat);
        } 
        else {
            $this->ajaxRandom();
        }
    }

    public function movieDetails($id)
    {
        $apiTMDB = new APITmdbController();

        $movie_search = $apiTMDB->callTMDBAPIMovieDetails($id);

        // Retrieve movie details
        $movie_title = $movie_search['original_title'];
        $movie_tagline = $movie_search['tagline'];
        $movie_production_year = $movie_search['release_date'];
        $movie_rating = intval($movie_search['vote_average']);
        $movie_poster = $movie_search['poster_path'];
        $movie_synopsis = $movie_search['overview'];
        $movie_nationality = $movie_search['production_countries']['0']['iso_3166_1'];

        $movie_all_nationality = [];
        foreach($movie_search['production_countries'] as $prod_countrie){
            $movie_all_nationality[] = $prod_countrie['iso_3166_1'];
        }
        
        $movie_genre = $movie_search['genres'];
        $new_genre = [];
        foreach ($movie_search['genres'] as $genre) {
            $new_genre[] = $genre['name'];
        }

        $movie_genre = implode(', ', $new_genre);

        $movie_runtime = ($movie_search['runtime']);
        $movie_id = $movie_search['id'];
        $movie_search_trailer = $apiTMDB->callTMDBAPIMovieTrailer($id);
        if(!empty ($movie_search_trailer['results'])){
            $movie_key_trailer = $movie_search_trailer['results']['0']['key'];
        }

        // Mise en BDD
        if(!empty($_POST)){

        }


        return $this->render('movie/movie_details.html.twig', [
            'original_title' => $movie_title,
            'movie_tagline' => $movie_tagline,
            'release_date' => $movie_production_year,
            'rating' => $movie_rating,
            'poster_path' => $movie_poster,
            'synopsis' => $movie_synopsis,
            'nationality' => $movie_nationality,
            'genre' => $movie_genre,
            'runtime' => $movie_runtime,
            'movie_id' => $movie_id,
            'movie_results'   => $movie_results ?? [],
            'movie_key_trailer' => $movie_key_trailer ?? '',
            'movie_all_nationality' => $movie_all_nationality,
            
        ]);
    }

    public function findMovie()
    {

        $showCarousel = false;
        $showRandom=false;
        // Retrieve data regarding film Genre
        $apiTMDB = new APITmdbController();

        if (isset($_GET['with_genres'])) {
            $genre_selected = $_GET['with_genres'];
            $movie_genres = [];
            foreach ($_GET['with_genres'] as $chooseGenre) {
                $movie_genres[] = $chooseGenre;
            }
            $genre_selected = implode(', ', $movie_genres);
            
            // Call the API method & retrieve results
            $findmovies = $apiTMDB->callTMDBAPIDiscoverGenre($chooseGenre);
            $movie_results = $findmovies['results'];
        }
        // Retrieve data regarding film release Year
        if (isset($_GET['release_date'])) {
            $years_selected = $_GET['release_date'];
            $movie_year = explode(',', $years_selected);
            // Call the API method & retrieve results
            $findmovies = $apiTMDB->callTMDBAPIDiscoverYear($movie_year[0],$movie_year[1]);
            // $movie_results = $findmovies['results'];
            $movie_results_year = $findmovies['results'];
            
            
        } 

        // Retrieve data regarding film Runtime
        if (isset($_GET['with_runtime'])) {
            $runtime_selected = $_GET['with_runtime'];
            $movie_runtime = explode(',', $runtime_selected);
            
            // Call the API method & retrieve results
            $findmovies = $apiTMDB->callTMDBAPIDiscoverRuntime($movie_runtime[0],$movie_runtime[1]);
            $movie_results_runtime = $findmovies['results'];
            
        } 

        // Retrieve all data from API

        if (isset($_GET['with_genres']) && isset($_GET['release_date']) && isset($_GET['with_runtime'])) {
            $showCarousel = true;
            $showRandom=true;
            $data_genres = implode(',', $_GET['with_genres']);
            
            $data_release = explode(',', $_GET['release_date']);
            $data_runtime = explode(',', $_GET['with_runtime']);

            // Call the API method & retrieve results
            $findmovies = $apiTMDB->callTMDBAPIDiscoverAll($data_genres, $data_release[0], $data_release[1], $data_runtime[0], $data_runtime[1]);
            $movie_results_global = $findmovies['results'];
            
        } 


        return $this->render('movie/movie_find.html.twig', [
            'showCarousel'   => $showCarousel,
            'showRandom'   => $showRandom,

            // In case of separate results
            // 'movie_results'   => $movie_results ?? [],
            // 'movie_results_runtime'   => $movie_results_runtime ?? [],
            // 'movie_results_year'     => $movie_results_year ?? [],
            'movie_results_global' => $movie_results_global ?? [],

        ]);
    }
}