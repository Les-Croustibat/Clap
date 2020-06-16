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

    public function viewedRated()
    {
        $apiTMDB=new APITmdbController();
        $topRated = $apiTMDB->calltopRated();
        $mostViewed = $apiTMDB->callmostViewed();
        
        
        return $this->render('user/user_space.html.twig',[
            'topRated' => array_slice($topRated['results'], 1),
            'mostViewed' => $mostViewed['results'],
        ]);
    }

    // créer une route spécifique qui permettra d'accéder a cette page, meme si elle sera invisible
    public function ajaxApiperson(){
        if(!empty($_GET)){
            // nettoie les donnees
            $safe = array_map('trim', array_map('strip_tags', $_GET));

            $Api= new APIAllocineController();
            $resultat = $Api -> callAPIPartner($safe['actor'],'person');

            // je retourne le resultat de mon API en JSON
            if($resultat['feed']['totalResults'] == 0){
                dd($resultat);
                return $this->json(['status' => 'ko', 'error' => 'Désolé, cette personne est introuvable']);

            }else{
                $retourJSON= $resultat['feed']['person'][0]['realName'];
                return $this->json(['status' => 'ok', 'result' =>$retourJSON]);
            }

        }else{
            // je retourne une erreur JSON
            // return $this->json(['error'=>'Aucune donnée reçues']);
        }
    }
}


