<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MovieController extends AbstractController
{
    public function movieDetails()
    {
        return $this->render('movie/movie_details.html.twig');
    }
    public function findMovie()
    {
        return $this->render('movie/movie_find.html.twig');
    }
}
