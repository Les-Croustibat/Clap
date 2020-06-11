<?php

namespace App\Controller;

use App\Controller\APIAllocineController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class UserController extends AbstractController
{

    public function userSpace()
    {
        // var request = new XMLHttpRequest();
        // request.onreadystatechange = function() {
        //     if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
        //         var response = JSON.parse(this.responseText);
        //         console.log(response.current_condition.condition);
        //     }
        // };
        // request.open("GET", "http://api.allocine.fr/rest/v3/search");
        // request.send();        
        // dump($request);

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
            // nettoeyr les donnees
            $safe = array_map('trim', array_map('strip_tags', $_POST));

            $Api= new APIAllocineController;
            $resultat = $Api -> callAPIPartner($safe['actor'],'person');

            return $this->json($resultat);
        }
    }
}

