<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TmdbController extends AbstractController
{
    /**
     * @Route("/tmdb", name="tmdb")
     */
    protected $apiURL = 'https://api.themoviedb.org/3';
    protected $apiKey = '8b5753049f43a637a087b0c90b698ac7';

    // Fonction de test (random) d'utilisation de tmdb => sortir le titre d'un film
    public function callMovie($id=null)
    {
        // id = correspond à l'id du film; chaque film a un id
        if(empty($id)) {


            return false;

        }  else {

            //https://api.themoviedb.org/3/movie/12?api_key=8b5753049f43a637a087b0c90b698ac7&language=fr
            //Requête que doit ressortir de curl

            $endpoint = $this->apiURL.'/movie'.'/'.$id;
            $timeout = 10; 

            //Seulement deux queries, l'api_key et le languague
            $parameters_request = [
                'api_key'  => $this->apiKey,
                'language' => 'fr'
            ];

            //dd($request) => pour voir la fin de la requête à partir du query
			$request= '?'.http_build_query($parameters_request);
            
            $curl = curl_init();

            $options=[
                CURLOPT_URL            => $endpoint.$request, // target the API URL
                CURLOPT_RETURNTRANSFER => true, // return the content into a string
                CURLOPT_CONNECTTIMEOUT => $timeout, // set a timeout i.e. maximum time the connection is allowed to take 
            ];
            
            if(empty($curl)){
                die("ERREUR curl_init : cURL is not available.");
            }

            curl_setopt_array($curl,$options);
        
            $response=curl_exec($curl);            
        
            curl_close($curl);

            $decode_response=json_decode($response, true);


        }
                
        return $decode_response;
    }
}
