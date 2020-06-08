<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ErrorController extends AbstractController
{
    public function error403()
    {
        return $this->render('error/error403.html.twig');
    }
    public function error404()
    {
        return $this->render('error/error404.html.twig');
    }
    public function error500()
    {
        return $this->render('error/error500.html.twig');
    }

}
