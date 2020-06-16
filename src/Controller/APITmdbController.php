<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Respect\Validation\Validator as v;

class APITmdbController extends AbstractController
{

    protected $apiToken='8b5753049f43a637a087b0c90b698ac7'; 
    protected $apiURL='https://api.themoviedb.org/3';

    // Retrieve a random film
    public function callTMDBAPIRandom ($id=null)
    {
        if(empty($id)) {            
            return false;        
        }  else {     

            $endpoint = $this->apiURL.'/movie'.'/'.$id;
            $timeout = 10;   
                  
            $parameters_request = [
                'api_key'  => $this->apiToken,
                'language' => 'FR'
            ];           
             
            $request= '?'.http_build_query($parameters_request);            
            $curl = curl_init();            
            
            $options=[
                CURLOPT_URL            => $endpoint.$request, 
                CURLOPT_RETURNTRANSFER => true, 
                CURLOPT_CONNECTTIMEOUT => $timeout, 
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

    // Retrieve data from the API with the film ID: film details 
    public function callTMDBAPIMovieDetails($movieId = null)
    {

        if (empty($movieId)) {
            // if API not called with parameters, no search
            return false;
        } else {

            // Define the URL with endpoint
            $endpoint = $this->apiURL . '/movie/';
            $apiKey= $this->apiToken;
            $timeout = 10;

            // Initialize the curl
            $curl = curl_init();

            // Set the curl options
            $options = [
                CURLOPT_URL            => $endpoint . $movieId . '?api_key='.$apiKey.'&language=fr', // target the API URL
                CURLOPT_RETURNTRANSFER => true, // return the content into a string
                CURLOPT_CONNECTTIMEOUT => $timeout, // set a timeout i.e. maximum time the connection is allowed to take 
            ];
    
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

    // Retrieve the film trailer
    public function callTMDBAPIMovieTrailer($movieId = null)
    {        
        if (empty($movieId)) {            // if API not called with parameters, no search            return false;
             return false;
        } else {            
            
            // Define the URL with endpoint
            $endpoint = $this->apiURL . '/movie/';
            $timeout = 10;            // Query paramaters
            
            $curl = curl_init();            // Set the curl options
            $options = [
                CURLOPT_URL            => $endpoint .$movieId.'/videos'.'?api_key=8b5753049f43a637a087b0c90b698ac7&language=eng-US', // target the API URL
                CURLOPT_RETURNTRANSFER => true, // return the content into a string
                CURLOPT_CONNECTTIMEOUT => $timeout, // set a timeout i.e. maximum time the connection is allowed to take 
               
            ];
            
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

    // Retrieve data from the API films with same genre
    public function callTMDBAPIDiscoverGenre($searchedGenre=null)
    {

        if(empty($searchedGenre)) {
            // if API not called with parameters, no search
            return false;

        }  else {

        // Define the URL with endpoint
        $endpoint = $this->apiURL.'/discover/movie';
        $apiKey= $this->apiToken;
        $timeout = 10;

        // Initialize the curl
        $curl = curl_init();

        // Set the curl options
        $options = [
            CURLOPT_URL            => $endpoint.'?with_genres='.$searchedGenre.'&api_key='.$apiKey.'&language=fr', // target the API URL
            CURLOPT_RETURNTRANSFER => true, // return the content into a string
            CURLOPT_CONNECTTIMEOUT => $timeout, // set a timeout i.e. maximum time the connection is allowed to take 
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

        }

        return $decode_response;
    }

    // Retrieve data from the API films with release year
    public function callTMDBAPIDiscoverYear($movie_year1, $movie_year2) {

        if(empty($movie_year1 & $movie_year2)) {
            // if API not called with parameters, no search
            return false;

        }  else {

            // Define the URL with endpoint
            $endpoint = $this->apiURL.'/discover/movie';
            $apiKey= $this->apiToken;
            $timeout = 10; 
            
            // Initialize the curl
            $curl = curl_init();

            // Set the url params
            $urlParams = '?api_key='.$apiKey.'&language=fr';
            if(isset($movie_year1) && !empty($movie_year1)){
                $urlParams.= '&release_date.gte='.$movie_year1.'-01-01';
            }
            if(isset($movie_year2) && !empty($movie_year2)){
                $urlParams.= '&release_date.lte='.$movie_year2.'-12-31';
            }

            // Set the curl options
            $options=[
                CURLOPT_URL            => $endpoint.$urlParams,
                CURLOPT_RETURNTRANSFER => true, // return the content into a string
                CURLOPT_CONNECTTIMEOUT => $timeout, // set a timeout i.e. maximum time the connection is allowed to take 
            ];
        
            // Error message
            if(empty($curl)){
                die("ERREUR curl_init : cURL is not available.");
            }

            // Config download options
            curl_setopt_array($curl,$options);
        
            // Execute the query
            $response=curl_exec($curl); 
            ///dd(curl_getinfo($curl));

            // Close
            curl_close($curl);

            // Decode the response (true, key and value -> PHP)
            $decode_response=json_decode($response, true);

        }

        return $decode_response;
    }

    // Retrieve data from the API films with the runtime
    public function callTMDBAPIDiscoverRuntime($movie_runtime1, $movie_runtime2) {

        if(empty($movie_runtime1 & $movie_runtime2)) {
            // if API not called with parameters, no search
            return false;

        }  else {

            // Define the URL with endpoint
            $endpoint = $this->apiURL.'/discover/movie';
            $apiKey= $this->apiToken;
            $timeout = 10; 
            
            // Initialize the curl
            $curl = curl_init();

            // Set the url params
            $urlParams = '?api_key='.$apiKey.'&language=fr';
            if(isset($movie_runtime1) && !empty($movie_runtime1)){
                $urlParams.= '&with_runtime.gte='.$movie_runtime1;
            }
            if(isset($movie_runtime2) && !empty($movie_runtime2)){
                $urlParams.= '&with_runtime.lte='.$movie_runtime2;
            }

            // Set the curl options
            $options=[
                CURLOPT_URL            => $endpoint.$urlParams,
                CURLOPT_RETURNTRANSFER => true, // return the content into a string
                CURLOPT_CONNECTTIMEOUT => $timeout, // set a timeout i.e. maximum time the connection is allowed to take 
            ];
        
            // Error message
            if(empty($curl)){
                die("ERREUR curl_init : cURL is not available.");
            }

            // Config download options
            curl_setopt_array($curl,$options);
        
            // Execute the query
            $response=curl_exec($curl); 
            curl_getinfo($curl);

            // Close
            curl_close($curl);

            // Decode the response (true, key and value -> PHP)
            $decode_response=json_decode($response, true);

        }

        return $decode_response;
    }

    // Retrieve all data from the API films with the genre, year & runtime
    public function callTMDBAPIDiscoverAll($searchedGenre=null, $movie_year1, $movie_year2, $movie_runtime1, $movie_runtime2) {

        if(empty($searchedGenre && $movie_year1 && $movie_year2 && $movie_runtime1 && $movie_runtime2)) {
            // if API not called with parameters, no search
            return false;

        }  else {

            // Define the URL with endpoint
            $endpoint = $this->apiURL.'/discover/movie';
            $apiKey= $this->apiToken;
            $timeout = 10; 
            
            // Initialize the curl
            $curl = curl_init();

            // Set the url params
            $urlParams = '?api_key='.$apiKey.'&language=fr&with_genres='.$searchedGenre;
            if((isset($movie_runtime1) && !empty($movie_runtime1)) && (isset($movie_year1) && !empty($movie_year1))){
                $urlParams.= '&with_runtime.gte='.$movie_runtime1.'&release_date.gte='.$movie_year1.'-01-01';
            }
            if((isset($movie_runtime2) && !empty($movie_runtime2))&& (isset($movie_year2) && !empty($movie_year2))){
                $urlParams.= '&with_runtime.lte='.$movie_runtime2.'&release_date.lte='.$movie_year2.'-12-31';
            }

            // Set the curl options
            $options=[
                CURLOPT_URL            => $endpoint.$urlParams.'#go',
                CURLOPT_RETURNTRANSFER => true, // return the content into a string
                CURLOPT_CONNECTTIMEOUT => $timeout, // set a timeout i.e. maximum time the connection is allowed to take 
            ];
        
            // Error message
            if(empty($curl)){
                die("ERREUR curl_init : cURL is not available.");
            }

            // Config download options
            curl_setopt_array($curl,$options);
        
            // Execute the query
            $response=curl_exec($curl); 
            curl_getinfo($curl);

            // Close
            curl_close($curl);

            // Decode the response (true, key and value -> PHP)
            $decode_response=json_decode($response, true);

            //$searchedGenre=null, $movie_year1, $movie_year2, $movie_runtime1, $movie_runtime2

            $new_results = [];
            if(!empty($decode_response['results'])){
                
                foreach($decode_response['results'] as $movie_found){

                    if(v::date()->between($movie_year1.'-01-01', $movie_year2.'-12-31')->validate($movie_found['release_date'])){
                        $new_results[] = $movie_found;
                    }

                }
                

                
                return ['results' => $new_results];

            }

        }

        return $decode_response;
    }

    public function calltopRated()
    {
   
        $endpoint = $this->apiURL.'/discover/movie';
        $timeout = 10; 

        $curl = curl_init();

        // Set the curl options
        $options = [
            CURLOPT_URL            => $endpoint.'?api_key=8b5753049f43a637a087b0c90b698ac7&language=fr?certification_country=US&certification=R&sort_by=vote_average.desc', // target the API URL
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
        
        return $decode_response;
    }
    public function callmostViewed()
    {
   
        $endpoint = $this->apiURL.'/discover/movie';
        $timeout = 10; 

        $curl = curl_init();

        // Set the curl options
        $options = [
            CURLOPT_URL            => $endpoint.'?api_key=8b5753049f43a637a087b0c90b698ac7&language=fr?sort_by=popularity.desc', // target the API URL
            CURLOPT_RETURNTRANSFER => true, // return the content into a string
            CURLOPT_CONNECTTIMEOUT => $timeout, // set a timeout i.e. maximum time the connection is allowed to take 
            //CURLOPT_TIMEOUT        => $timeout, // set a timeout i.e. maximum time the request is allowed to take 
            // CURLOPT_USERAGENT      => $this->getRandomUserAgent(), // call the function getRandomUserAgent to fake an android user as the API is for Android
        ];

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
        
        return $decode_response;
    }


}



