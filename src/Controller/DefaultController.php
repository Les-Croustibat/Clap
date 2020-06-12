<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class DefaultController extends AbstractController
{
    public function home()
    {
        return $this->render('default/home.html.twig');
    }

    public function contact(MailerInterface $mailer)
    {
        if(!empty($_POST)){
                $safe = array_map('strip_tags', $_POST);

                $errors = [
                        (empty($safe['lastname'])) ? 'Votre nom doit être valide' : null,
                        (empty($safe['firstname'])) ? 'Votre prénom doit être valide' : null,
                        (!filter_var($safe['email'], FILTER_VALIDATE_EMAIL)) ? 'Votre mail doit être valide' : null,
                        (empty($safe['object'])) ? 'Votre champ objet doit être valide' : null,
                        (empty($safe['message'])) ? 'Votre message doit être valide.' : null,
                ];

                $errors = array_filter($errors);
        
                if(count($errors) === 0){
                    $messageHTML = '<p>Bonjour,';
                    $messageHTML.= '<br>Vous avez été contacté par le formulaire de votre site.</p>';
                    $messageHTML.= '<ul>';
                    $messageHTML.= '<li>Nom & prénom : '.mb_strtoupper($safe['lastname']).' '.$safe['firstname'].'</li>';
                    $messageHTML.= '<li>Objet : '.$safe['object'].' '.'</li>';
                    $messageHTML.= '<li>Message : '.nl2br($safe['message']).' '.'</li>';
                    $messageHTML.= '</ul>';

                    $email = new Email();
                    $email->from($safe['email']);
                    $email->to('contact@clap.fr');
                    $email->replyTo($safe['email']);
        
                    $email->subject('Contact du site en date du '.date('d/m/Y H:i'));
                    $email->html($messageHTML); 
                    $email->text(strip_tags($messageHTML)); 

                    $mailer->send($email);
                    $this->addFlash('success', 'Votre message a bien été envoyé');
                } else {
                    dump($safe);
                    $errorsMessage = implode('<br>', $errors);
                    $this->addFlash('danger', $errorsMessage);
                }
            }
        
        return $this->render('default/contact.html.twig', [
            'input' => $safe ?? [], 
        ]);       
    }

    public function credits()
    {
        return $this->render('default/credits.html.twig');
    }

    public function about()
    {
        return $this->render('default/about.html.twig');
    }

    public function legalNotice()
    {
        return $this->render('default/legal-notice.html.twig');
    }

}
