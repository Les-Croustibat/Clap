<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class APITmdbController extends AbstractController
{

    protected $apiToken='8b5753049f43a637a087b0c90b698ac7'; 
    protected $apiURL='https://api.themoviedb.org/3/search/movie?api_key='.$apiToken.'&language=fr&query='.$criteria;


    public function callTMDBAPI ($search=null) {


        return $decode_response;
    }
}
