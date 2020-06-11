<?php

namespace App\Controller;

use App\Controller\APIAllocineController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    public function userSpace()
    {
        // $Api= new APIAllocineController;
        // $resultat = $Api -> callAPIPartner('Will Smith','person');
        // dd($resultat);

        return $this->render('user/user_space.html.twig');
    }
    public function resetPw()
    {
        return $this->render('user/user_resetPw.html.twig');
    }
    public function forgottenPw()
    {
        return $this->render('user/user_forgottenPw.html.twig');
    }


    // créer une route spécifique qui permettra d'accéder a cette page, meme si elle sera invisible
    public function ajaxApiperson(){
        if(!empty($_POST)){
            // nettoie les donnees
            $safe = array_map('trim', array_map('strip_tags', $_POST));

            $Api= new APIAllocineController();
            $resultat = $Api -> callAPIPartner($safe['acteur'],'person');
            // dd($resultat);
            return $this->json($resultat);
        }
    }
}

