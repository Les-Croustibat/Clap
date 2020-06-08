<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    public function userSpace()
    {
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

}
