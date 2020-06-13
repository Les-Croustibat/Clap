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

    // Fonction de test (random) d'utilisation de tmdb => sortir le titre d'un film ʕ•ᴥ•ʔ
    public function callMovieCriteria()
    {
        // id = correspond à l'id du film; chaque film a un id
            $endpoint = $this->apiURL.'/discover/movie';
            $timeout = 10; 

            //Seulement deux queries, l'api_key et le languague ʕ•ᴥ•ʔ
            $parameters_request = [
                'api_key'       => $this->apiKey,
                'language'      => 'fr',
                'include_adult' => false,
                'include_video' => false,
                'page'          => 2,
            ];

            //dd($request) => pour voir la fin de la requête à partir du query ʕ•ᴥ•ʔ
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
            curl_getinfo($curl);
            
            curl_close($curl);

            $decode_response=json_decode($response, true);
                
            return $decode_response;
        }
}
