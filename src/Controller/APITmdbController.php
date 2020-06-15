<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class APITmdbController extends AbstractController
{

    protected $apiToken = '8b5753049f43a637a087b0c90b698ac7';
    protected $apiURL = 'https://api.themoviedb.org/3';

    // Cancel maybe
    public function callTMDBAPIMovie($search = null)
    {

        if (empty($search)) {

            // if API not called with parameters, no search

            return false;
        } else {

            // Define the URL with endpoint
            $endpoint = $this->apiURL . '/movie/';
            $timeout = 10;

            // Query paramaters
            // $parameters_request = [
            //     'api_key'           => $this->apiToken,
            //     'language'          => 'fr',
            //     'title'             => $search,
            //     'genre_ids'         => 'genre_id',
            //     'origin_country'    => 'origin_country',
            //     'vote_average'      => 'vote_average',
            //     'include_adult'     => false,
            // ];

            // $request = '?' . http_build_query($parameters_request);

            // Initialize the curl
            $curl = curl_init();

            // Set the curl options
            $options = [
                CURLOPT_URL            => $endpoint.$search, // target the API URL
                CURLOPT_RETURNTRANSFER => true, // return the content into a string
                CURLOPT_CONNECTTIMEOUT => $timeout, // set a timeout i.e. maximum time the connection is allowed to take 
                //CURLOPT_TIMEOUT        => $timeout, // set a timeout i.e. maximum time the request is allowed to take 
                // CURLOPT_USERAGENT      => $this->getRandomUserAgent(), // call the function getRandomUserAgent to fake an android user as the API is for Android
            ];
            // dump($options);

            // Error message
            if (empty($curl)) {
                die("ERREUR curl_init : cURL is not available.");
            }

            // Config download options
            curl_setopt_array($curl, $options);

            // Execute the query
            $response = curl_exec($curl);

            // Close
            curl_close($curl);

            // Decode the response (true, key and value -> PHP)
            $decode_response = json_decode($response, true);
        }

        return $decode_response;
    }

    public function callTMDBAPIMovieDetails($movieId = null)
    {

        if (empty($movieId)) {

            // if API not called with parameters, no search

            return false;
        } else {

            // Define the URL with endpoint
            $endpoint = $this->apiURL . '/movie/';
            $timeout = 10;

            // Query paramaters
            //    $parameters_request = [
            //     'movie_id'                 => $movieId,
            //     'api_key'                  => $this->apiToken,
            //     'language'                 => 'fr',
            // 'title'                    => 'title',
            // 'adult'                    => false,
            // 'genres'                   => 'name',
            // 'production_countries'     => 'name',
            // 'popularity'               => 'popularity',
            // 'runtime'                  => 'runtime',
            // ];

            // $request= '?'.http_build_query($parameters_request);

            // Initialize the curl
            $curl = curl_init();

            // Set the curl options
            $options = [
                CURLOPT_URL            => $endpoint . $movieId . '?api_key=8b5753049f43a637a087b0c90b698ac7&language=fr', // target the API URL
                CURLOPT_RETURNTRANSFER => true, // return the content into a string
                CURLOPT_CONNECTTIMEOUT => $timeout, // set a timeout i.e. maximum time the connection is allowed to take 
                //CURLOPT_TIMEOUT        => $timeout, // set a timeout i.e. maximum time the request is allowed to take 
                // CURLOPT_USERAGENT      => $this->getRandomUserAgent(), // call the function getRandomUserAgent to fake an android user as the API is for Android
            ];
            // dump($options);

            // Error message
            if (empty($curl)) {
                die("ERREUR curl_init : cURL is not available.");
            }

            // Config download options
            curl_setopt_array($curl, $options);

            // Execute the query
            $response = curl_exec($curl);
            // curl_error($ch);

            // Close
            curl_close($curl);

            // Decode the response (true, key and value -> PHP)
            $decode_response = json_decode($response, true);
        }

        return $decode_response;
    }

    // For all information beside origin country & person
    public function callTMDBAPIDiscover($searchedGenre=null)
    {

        // if(empty($searchedGenre)) {

        //     // if API not called with parameters, no search

        //     return false;

        // }  else {

        // Define the URL with endpoint
        $endpoint = $this->apiURL.'/discover/movie';
        $timeout = 10;

        // Query paramaters
        // $parameters_request = [
        //     'api_key'                  => $this->apiToken,
        //     'language'                 => 'fr',
        //     'page'                     => 2,
        //     // 'primary_release_date.gte' => $searchedYear1,
        //     // 'primary_release_date.lte' => $searchedYear2,
        //     // 'with_people'              => 'with_people',
        //     'with_genres'              => $searchedGenre,
        //     // 'with_runtime.gte'         => 'with_runtime.gte',
        //     // 'vote_average.gte'         => 'vote_average.gte',
        //     'include_adult'            => false,

        // ];

        // // Build the query
        // $request = '?' . http_build_query($parameters_request);

        // Initialize the curl
        $curl = curl_init();

        // Set the curl options
        $options = [
            CURLOPT_URL            => $endpoint.'?with_genres='.$searchedGenre.'&api_key=8b5753049f43a637a087b0c90b698ac7&language=fr', // target the API URL
            CURLOPT_RETURNTRANSFER => true, // return the content into a string
            CURLOPT_CONNECTTIMEOUT => $timeout, // set a timeout i.e. maximum time the connection is allowed to take 
            //CURLOPT_TIMEOUT        => $timeout, // set a timeout i.e. maximum time the request is allowed to take 
        ];

        // Error message
        if (empty($curl)) {
            die("ERREUR curl_init : cURL is not available.");
        }

        // Config download options
        curl_setopt_array($curl, $options);

        // Execute the query
        $response = curl_exec($curl);
        curl_getinfo($curl);

        // Close
        curl_close($curl);

        // Decode the response (true, key and value -> PHP)
        $decode_response = json_decode($response, true);

        return $decode_response;
    }
}

