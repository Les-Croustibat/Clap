<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;

class SecurityController extends AbstractController
{
   
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // SI ON VEUT REDIRIGER VERS LA PAGE D ACCUEIL SI DEJA CONNECTE
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('default_home');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    
    public function logout()
    {
        // throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
        throw new \Exception();

        return $this->render('security/logout.html.twig');
    }


    public function logoutConfirm()
    {
        if (!empty($_POST)) {
            if (isset($_POST['action']) && $_POST['action'] === 'delete') {
                // header('Location: home.html.twig');
                return $this->redirectToRoute('security_logout');
            }
        }
        
        return $this->render('security/logout_confirm.html.twig');
    }
}
