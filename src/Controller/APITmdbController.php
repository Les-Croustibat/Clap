<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class APITmdbController extends AbstractController
{
    protected $apiURL = 'https://api.themoviedb.org/3/search/movie?api_key=16bdbdefd43637f8d2c69ac76284bc59&query=';
    // protected $apiKey = '16bdbdefd43637f8d2c69ac76284bc59';
    
    public function callAPIMovie($movie=null)
    {
        if(empty($movie)) {

            // if API not called with parameters, no search
            return false;

        }  else {
            
            // Query paramaters
            $parameters_request = [
                'query'         => $movie
            ];

            // String to search
            $request='?'.http_build_query($parameters_request);

            // Initialize the curl
            $curl = curl_init();

            // Set the curl options
            $options=[
                CURLOPT_URL            => $apiURL, // target the API URL
                CURLOPT_RETURNTRANSFER => true, // return the content into a string
            ];
            
            // Error message
            if(empty($curl)){
                die("ERREUR curl_init : cURL is not available.");
            }

            // Config download options
            curl_setopt_array($curl,$options);
        
            // Execute the query
            $response=curl_exec($curl);            
        
            // Close
            curl_close($curl);

            // Decode the response (true, key and value -> PHP)
            $decode_response=json_decode($response, true);

            // dump($decode_response['id_movie']);
            // die;

            // Decode the response (true, key and value -> PHP)
            $decode_response=json_decode($response, true);

            return $decode_response;
        }
    
        return $this->render('api_tmdb/index.html.twig');
    }
}
