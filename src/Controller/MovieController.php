<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Controller\APIAllocineController;

class MovieController extends AbstractController
{

    public function ajaxRandom(){
        $apiTmdb= new TmdbController();
        $resultat = $apiTmdb->callMovie(random_int(1, 999));
        return $this->json($resultat);
    }

    //    public function movieDetails()
    // {
    //     // on a bien cliqué sur un film pour avoir les infos
    //     $apiAllocine = new APIAllocineController();

    //     $movie_search = $apiAllocine->callAPIPartner('BadBoys');
    //     $movie_details_search = $apiAllocine->callAPIPartner2(14012);
    //     // die;

    //     // Récup le titre
    //     $movie_title = $movie_search['feed']['movie']['0']['originalTitle'];
    //     // Récup l'année de production
    //     $movie_production_year = $movie_search['feed']['movie']['0']['productionYear'];
    //     // Réalisateur
    //     $movie_director = $movie_search['feed']['movie']['0']['castingShort']['directors'];
    //     // Acteurs
    //     $movie_actors = $movie_search['feed']['movie']['0']['castingShort']['actors'];
    //     // Note
    //     $movie_rating = intval($movie_search['feed']['movie']['0']['statistics']['userRating']);
    //     // Affiche
    //     $movie_poster = $movie_search['feed']['movie']['0']['poster']['href'];
    //     // Synopsis
    //     $movie_synopsis = $movie_details_search['movie']['synopsis'];
    //     //Nationalité
    //     $movie_nationality = $movie_details_search['movie']['nationality']['0']['$'];
    //     // Genres
    //     $movie_genre = $movie_details_search['movie']['genre']['0']['$']; // 1 SEUL !! VOIR POUR PLUSIEURS
    //     $new_genre = [];
    //     foreach($movie_details_search['movie']['genre'] as $genre){
    //         $new_genre[] = $genre['$'];
    //     }
    //     $movie_genre = implode(', ', $new_genre);
    //     // Bande-Annonce
    //     // $movie_trailer = $movie_details_search['movie']['trailer']['href'];
    //     // Durée
    //     $movie_runtime = ($movie_details_search['movie']['runtime'])/60;


    //     return $this->render('movie/movie_details.html.twig', [
    //         'title' => $movie_title,
    //         'year' => $movie_production_year,
    //         'director' => $movie_director,
    //         'actors' => $movie_actors,
    //         'rating' => $movie_rating,
    //         'poster_link' => $movie_poster,
    //         'synopsis' => $movie_synopsis,
    //         'nationality' => $movie_nationality,
    //         'genre' => $movie_genre,
    //         // 'trailer' => $movie_trailer,
    //         'runtime' => $movie_runtime,
    //     ]);
    // }

    //Fonction de la route trouver un film pour afficher le film (A FAIRE EN AJAX !) ʕ•ᴥ•ʔ
    public function findMovie()
    {
         
         return $this->render('movie/movie_find.html.twig');
    }

}
