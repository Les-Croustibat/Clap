<?php

namespace App\Controller;

use App\Controller\APIAllocineController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    public function userSpace()
    {
        // coucou
        $Api= new APIAllocineController;
        $resultat = $Api -> callAPIPartner('will smith','person');
        dd($resultat);

        return $this->render('user/user_space.html.twig');
    }


    // créer une route spécifique qui permettra d'accéder a cette page, meme si elle sera invisible
    public function ajaxApiperson(){
        if(!empty($_GET)){
            dd($_GET);
            // nettoie les donnees
            $safe = array_map('trim', array_map('strip_tags', $_GET));

            $Api= new APIAllocineController();
            $resultat = $Api -> callAPIPartner($safe['actor'],'person');

            // je retourne le resultat de mon API en JSON
            if($resultat['feed']['totalResults'] == 0){
                return $this->json(['status' => 'ko', 'error' => 'Désolé, cette personne est introuvable']);

            }else{
                $retourJSON= $resultat['feed']['person'][0]['realName'];
                return $this->json(['status' => 'ok', 'result' =>$retourJSON]);
            }

        }else{
            //je retourne une erreur JSON
            return $this->json(['error'=>'Aucune donnée reçues']);
        }
    }
}

