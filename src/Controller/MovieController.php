<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Controller\APIAllocineController;
use App\Controller\APITmdbController;

class MovieController extends AbstractController
{

    public function movieDetails($id)
    {
        $apiTMDB = new APITmdbController();

        $movie_search = $apiTMDB->callTMDBAPIMovieDetails($id);

        // Get data from API
        $movie_title = $movie_search['original_title'];
        $movie_production_year = $movie_search['release_date'];
        $movie_rating = intval($movie_search['vote_average']);
        $movie_poster = $movie_search['poster_path'];
        $movie_synopsis = $movie_search['overview'];
        $movie_nationality = $movie_search['production_countries']['0']['iso_3166_1'];
        $movie_genre = $movie_search['genres'];
        $new_genre = [];
        foreach ($movie_search['genres'] as $genre) {
            $new_genre[] = $genre['name'];
        }
        $movie_genre = implode(', ', $new_genre);
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
            
        } else {
            // improve
            echo 'Vous n\'avez pas coché de case';
        }

        // Retrieve data regarding film release Year
        if (isset($_GET['release_date'])) {
            $years_selected = $_GET['release_date'];
            $movie_year = explode(',', $years_selected);
            // Call the API method & retrieve results
            $findmovies = $apiTMDB->callTMDBAPIDiscoverYear($movie_year[0],$movie_year[1]);
            // $movie_results = $findmovies['results'];
            $movie_results_year = $findmovies['results'];
            
            
        } else {
            echo 'Vous n\'avez pas sélectionné une période';
        }

        // Retrieve data regarding film Runtime
        if (isset($_GET['with_runtime'])) {
            $runtime_selected = $_GET['with_runtime'];
            $movie_runtime = explode(',', $runtime_selected);
            
            // Call the API method & retrieve results
            $findmovies = $apiTMDB->callTMDBAPIDiscoverRuntime($movie_runtime[0],$movie_runtime[1]);
            $movie_results_runtime = $findmovies['results'];
            
        } else {
            echo 'Vous n\'avez pas sélectionné une durée';
        }

        // Retrieve all data from API
        if (isset($_GET['with_genres']['release_date']['with_runtime'])) {
            $data_selected = $_GET['with_genres']['release_date']['with_runtime'];
            $movie_data = explode(',', $data_selected);
            
            // Call the API method & retrieve results
            $findmovies = $apiTMDB->callTMDBAPIDiscoverAll($movie_data[0], $movie_data[1], $movie_data[2], $movie_data[3], $movie_data[4]);
            $movie_results_global = $findmovies['results'];
            
        } else {
            echo 'Vous n\'avez pas sélectionné tous les critères';
        }

        

        return $this->render('movie/movie_find.html.twig', [

            // 'movie_results'   => $movie_results ?? [],
            // 'movie_results_runtime'   => $movie_results_runtime ?? [],
            // 'movie_results_year'     => $movie_results_year ?? [],
            'movie_results_global' => $movie_results_global ?? [],

        ]);
    }


}