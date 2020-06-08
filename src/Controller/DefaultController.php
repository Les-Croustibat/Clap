<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    public function home()
    {
        return $this->render('default/home.html.twig');
    }

    public function contact()
    {
        return $this->render('default/contact.html.twig');
    }

    public function credits()
    {
        return $this->render('default/credits.html.twig');
    }
    
    public function about()
    {
        return $this->render('default/about.html.twig');
    }

}
