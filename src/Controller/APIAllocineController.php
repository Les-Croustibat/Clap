<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class APIAllocineController extends AbstractController
{
    
    protected $apiURL = 'http://api.allocine.fr/rest/v3';
    protected $apiKey = '100043982026';
    protected $secretKey = '29d185d98c984a359e6e6f26a0474269';

    public function callAPIPartner($search=null)
    {
        if(empty($search)) {

            // if API not called with parameters, no search

            return false;

        }  else {

            // Search parameters => a person (actor, director) then call the API
            // Define the URL with endpoint
            $endpoint = $this->apiURL.'/search';
            $timeout = 10; 

            // Query paramaters
            $parameters_request = [
                'partner'   => $this->apiKey,
                'q'         => $search,
                'filter'    => 'movie',
                'format'   => 'json',
            ];

            // String to search
            $sed = date('Ymd');
			$sig = urlencode(base64_encode(sha1($this->secretKey.http_build_query($parameters_request).'&sed='.$sed, true)));
			$request= '?'.http_build_query($parameters_request).'&sed='.$sed.'&sig='.$sig;

            // Initialize the curl
            $curl = curl_init();

            // Set the curl options
            $options=[
                CURLOPT_URL            => $endpoint.$request, // target the API URL
                CURLOPT_RETURNTRANSFER => true, // return the content into a string
                CURLOPT_CONNECTTIMEOUT => $timeout, // set a timeout i.e. maximum time the connection is allowed to take 
                //CURLOPT_TIMEOUT        => $timeout, // set a timeout i.e. maximum time the request is allowed to take 
                CURLOPT_USERAGENT      => $this->getRandomUserAgent(), // call the function getRandomUserAgent to fake an android user as the API is for Android
            ];
            dump($options);
            
            // Error message
            if(empty($curl)){
                die("ERREUR curl_init : cURL is not available.");
            }

            // Config download options
            curl_setopt_array($curl,$options);
        
            // Execute the query
            $response=curl_exec($curl);            
        
            dump(curl_getinfo($curl));

            // Close
            curl_close($curl);

            // Decode the response (true, key and value -> PHP)
            $decode_response=json_decode($response, true);

            dump($decode_response);
            die;

        }
        
        // DO NOT FORGET !!! no render just a return of data
        return $decode_response;
    }
    
    public function callAPIMovie($film_search=null, $movie=null)
    {
        if(empty ($movie)) {

            // if API not called with parameters, no search

            return false;

        }  else {

            // Search parameters => a movie then call the API
            // Define the URL with endpoint
            $endpoint = $this->apiURL.'/search';
            $timeout = 10; 
            
            // Query paramaters
            $parameters_request = [
                'q'         => $film_search,
                'partner'   => $this->apiKey,
                'filter'    => 'movie',
                'format '   => 'json',
            ];

            // String to search
            $request='?'.http_build_query($parameters_request);

            // Initialize the curl
            $curl = curl_init();

            // Set the curl options
            $options=[
                CURLOPT_URL            => $endpoint.$request, // target the API URL
                CURLOPT_RETURNTRANSFER => true, // return the content into a string
                CURLOPT_CONNECTTIMEOUT => $timeout, // set a timeout i.e. maximum time the connection is allowed to take 
                CURLOPT_TIMEOUT        => $timeout, // set a timeout i.e. maximum time the request is allowed to take 
                CURLOPT_USERAGENT      => $this->getRandomUserAgent(),
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

            // Query paramaters
            $parameters_request = [
                'partner'   => $this->apiKey,
                'code'      => $movie,
                'filter'    => 'movie',
                'profile'   => 'large',
                'striptags' => 'synopsis,synopsisshort',
                'format '   => 'json',
            ];

            // String to search
            $request='?'.http_build_query($parameters_request);

            // Initialize the curl
            $curl = curl_init();

            // Set the curl options
            $options=[
                CURLOPT_URL            => $endpoint.$request, // target the API URL
                CURLOPT_RETURNTRANSFER => true, // return the content into a string
                CURLOPT_CONNECTTIMEOUT => $timeout, // set a timeout i.e. maximum time the connection is allowed to take 
                CURLOPT_TIMEOUT        => $timeout, // set a timeout i.e. maximum time the request is allowed to take
                CURLOPT_USERAGENT      => $this->getRandomUserAgent(),
            
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

            return $decode_response;

        }
    }

    public function callAPIPerson($person_search=null, $film_search=null)
    {
        if(empty($person_search)) {

            // if API not called with parameters, no search

            return false;

        }  else {

            // Search parameters => a person (actor, director) then call the API
            // Define the URL with endpoint
            $endpoint = $this->apiURL.'/search';
            $timeout = 10; 

            // Query paramaters
            $parameters_request = [
                'q'         => $person_search,
                'partner'   => $this->apiKey,
                'filter'    => 'person',
                'format '   => 'json',
            ];

            // String to search
            $request='?'.http_build_query($parameters_request);

            // Initialize the curl
            $curl = curl_init();

            // Set the curl options
            $options=[
                CURLOPT_URL            => $endpoint.$request, // target the API URL
                CURLOPT_RETURNTRANSFER => true, // return the content into a string
                CURLOPT_CONNECTTIMEOUT => $timeout, // set a timeout i.e. maximum time the connection is allowed to take 
                CURLOPT_TIMEOUT        => $timeout, // set a timeout i.e. maximum time the request is allowed to take 
                CURLOPT_USERAGENT      => $this->getRandomUserAgent(), // call the function getRandomUserAgent to fake an android user as the API is for Android
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

            // Query paramaters
            $parameters_request = [
                'partner'   => $this->apiKey,
                'code'      => $film_search,
                'filter'    => 'movie',
                'profile'   => 'large',
                'format '   => 'json',
            ];

            // String to search
            $request='?'.http_build_query($parameters_request);

            // Initialize the curl
            $curl = curl_init();

            // Set the curl options
            $options=[
                CURLOPT_URL            => $endpoint.$request, // target the API URL
                CURLOPT_RETURNTRANSFER => true, // return the content into a string
                CURLOPT_CONNECTTIMEOUT => $timeout, // set a timeout i.e. maximum time the connection is allowed to take 
                CURLOPT_TIMEOUT        => $timeout, // set a timeout i.e. maximum time the request is allowed to take
                CURLOPT_USERAGENT      => $this->getRandomUserAgent(),
            
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

            return $decode_response;

        }
    }

    private function getRandomUserAgent()
	{
		$v = rand(1, 4).'.'.rand(0, 9);
		$a = rand(0, 9);
		$b = rand(0, 99);
		$c = rand(0, 999);


		$userAgents = [
            "Mozilla/5.0 (Linux; U; Android $v; fr-fr; Nexus One Build/FRF91) AppleWebKit/5$b.$c (KHTML, like Gecko) Version/$a.$a Mobile Safari/5$b.$c",
            "Mozilla/5.0 (Linux; U; Android $v; fr-fr; Dell Streak Build/Donut AppleWebKit/5$b.$c+ (KHTML, like Gecko) Version/3.$a.2 Mobile Safari/ 5$b.$c.1",
            "Mozilla/5.0 (Linux; U; Android 4.$v; fr-fr; LG-L160L Build/IML74K) AppleWebkit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30",
            "Mozilla/5.0 (Linux; U; Android 4.$v; fr-fr; HTC Sensation Build/IML74K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30",
            "Mozilla/5.0 (Linux; U; Android $v; en-gb) AppleWebKit/999+ (KHTML, like Gecko) Safari/9$b.$a",
            "Mozilla/5.0 (Linux; U; Android $v.5; fr-fr; HTC_IncredibleS_S710e Build/GRJ$b) AppleWebKit/5$b.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/5$b.1",
            "Mozilla/5.0 (Linux; U; Android 2.$v; fr-fr; HTC Vision Build/GRI$b) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1",
            "Mozilla/5.0 (Linux; U; Android $v.4; fr-fr; HTC Desire Build/GRJ$b) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1",
            "Mozilla/5.0 (Linux; U; Android 2.$v; fr-fr; T-Mobile myTouch 3G Slide Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1",
            "Mozilla/5.0 (Linux; U; Android $v.3; fr-fr; HTC_Pyramid Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1",
            "Mozilla/5.0 (Linux; U; Android 2.$v; fr-fr; HTC_Pyramid Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari",
            "Mozilla/5.0 (Linux; U; Android 2.$v; fr-fr; HTC Pyramid Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/5$b.1",
            "Mozilla/5.0 (Linux; U; Android 2.$v; fr-fr; LG-LU3000 Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/5$b.1",
            "Mozilla/5.0 (Linux; U; Android 2.$v; fr-fr; HTC_DesireS_S510e Build/GRI$a) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/$c.1",
            "Mozilla/5.0 (Linux; U; Android 2.$v; fr-fr; HTC_DesireS_S510e Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile",
            "Mozilla/5.0 (Linux; U; Android $v.3; fr-fr; HTC Desire Build/GRI$a) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1",
            "Mozilla/5.0 (Linux; U; Android 2.$v; fr-fr; HTC Desire Build/FRF$a) AppleWebKit/533.1 (KHTML, like Gecko) Version/$a.0 Mobile Safari/533.1",
            "Mozilla/5.0 (Linux; U; Android $v; fr-lu; HTC Legend Build/FRF91) AppleWebKit/533.1 (KHTML, like Gecko) Version/$a.$a Mobile Safari/$c.$a",
            "Mozilla/5.0 (Linux; U; Android $v; fr-fr; HTC_DesireHD_A9191 Build/FRF91) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1",
            "Mozilla/5.0 (Linux; U; Android $v.1; fr-fr; HTC_DesireZ_A7$c Build/FRG83D) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/$c.$a",
            "Mozilla/5.0 (Linux; U; Android $v.1; en-gb; HTC_DesireZ_A7272 Build/FRG83D) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/$c.1",
            "Mozilla/5.0 (Linux; U; Android $v; fr-fr; LG-P5$b Build/FRG83) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1"
        ];


		return $userAgents[rand(0, count($userAgents) - 1)];
	}
}
