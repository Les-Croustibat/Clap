<?php

namespace App\Controller;

use App\Controller\APIAllocineController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    public function userSpace()
    {
       
        // $Api= new APIAllocineController;
        // $resultat = $Api -> callAPIPartner('will smith','person');
        // return $this->render('user/user_space.html.twig');
    }


    // créer une route spécifique qui permettra d'accéder a cette page, meme si elle sera invisible
    public function ajaxApiperson(){
        // $errors=[];
        if(!empty($_GET)){
            // nettoie les donnees
            $safe = array_map('trim', array_map('strip_tags', $_GET));

            // if (strlen($safe['acteur']) < 3 || strlen($safe['acteur']) > 20) {
                // $errors[] = 'Nom doit être compris entre 3 et 20 caractères';
        // }
            $Api= new APIAllocineController();
            $resultat = $Api -> callAPIPartner($safe['actor'],'person');

            // je retourne le resultat de mon API en JSON
            if($resultat['feed']['totalResults'] == 0){
                return $this->json(['status' => 'ko', 'error' => 'Désolé, cette personne est introuvable']);

            }else{
                $retourJSON= $resultat['feed']['person'][0]['name'];
                return $this->json(['status' => 'ok', 'result' =>$retourJSON]);
            }

        }else{
            //je retourne une erreur JSON
            return $this->json(['error'=>'Aucune donnée reçues']);
        }
    }

    // enregistrement des infos de mon-espace dans la bdd
//     public function BddUserspace{

//     }
}

