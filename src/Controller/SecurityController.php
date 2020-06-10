<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    private $passwordEncoder;
   
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


    public function signIn(UserPasswordEncoderInterface $passwordEncoder)
    {   
        // Rediriger 
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('default_home');
        // }

        $this->passwordEncoder = $passwordEncoder;

        if(!empty($_POST)){

            $safe = array_map('trim', array_map('strip_tags', $_POST));

            // On accède au manager (connexion DB)
            $entityManager = $this->getDoctrine()->getManager(); 
            // On passe le paramètre $safe['email'] récupéré du POST pour chercher l'email donné
            $existing_email = $entityManager->getRepository(User::class)->findBy(["email"=>$safe['email']]);

            dump($safe);
            // CAPTCHA
            $secret = '6LdK1aIZAAAAAGwlAm1un76x0Db0stx3RejjBTFm';
            $gRecaptchaResponse = $safe['g-recaptcha-response'];

            $recaptcha = new \ReCaptcha\ReCaptcha($secret);
            $resp = $recaptcha->verify($gRecaptchaResponse, $_SERVER['REMOTE_ADDR']);

            dump($resp->isSuccess());
            $errors = [
                (strlen($safe['firstname']) < 3 || strlen($safe['firstname']) > 20) ? 'Votre prénom doit comporter entre 3 et 20 caractères.' : null,
                (strlen($safe['lastname']) < 3 || strlen($safe['lastname']) > 20) ? 'Votre nom doit comporter entre 3 et 20 caractères.' : null,
                (strlen($safe['pseudo']) < 3 || strlen($safe['pseudo']) > 20) ? 'Votre pseudo doit comporter entre 3 et 20 caractères.' : null,
                (!filter_var($safe['email'], FILTER_VALIDATE_EMAIL)) ?  'Votre email n\'est pas valide.' : null,
                (!empty($existing_email)) ? 'Cet email existe déjà.' : null,
                (strlen($safe['password']) < 3 || strlen($safe['password']) > 20) ? 'Votre mot de passe doit comporter entre 3 et 20 caractères.' : null,
                ($safe['password'] != $safe['confirmPassword']) ? 'Vos mots de passe ne sont pas identiques.' : null,
                (!$resp->isSuccess()) ? 'Le captcha n\'a pas été coché.' : null,
            ];
            
            // Automatiquement supprimer les entrées vides de mon tableau
            $errors = array_filter($errors);

            // Je compte les entrées de mon tableau $errors, s'il n'y en a pas, alors cela veut dire que les données ont bien été saisies
            if (count($errors) === 0 && $resp->isSuccess()) {
            /*
            * J'insère mes données puisque je suis sure que le formulaire a bien été complété
            */

                // use App\Entity\User ; -> a mettre tout en haut
                // Je prépare l'enregistrement de mes données dans la table
                $user = new User(); // J'utilise l'entity
                $user->setFirstName($safe['firstname']);
                $user->setLastName($safe['lastname']);
                $user->setPseudo($safe['pseudo']);
                $user->setEmail($safe['email']);
                $user->setPassword($this->passwordEncoder->encodePassword(
                    $user,
                    $safe['password'] // Ici c'est le mot de passe en clair de mes futurs users de test
                ));
                $user->setRoles(['ROLE_USER']);

                // Insertion des données SQL
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success', 'Inscription confirmée, bienvenue !');
                // FAIRE REDIRECTION !!!
            }
            else {
            // Il y a des erreurs
            $errorsMessage = implode('<br>', $errors);  // implode() transforme mon tableau d'erreur en une chaine de caractères
            $this->addFlash('danger', $errorsMessage);
            }
            
        } // Fin isset post

        return $this->render('security/sign_in.html.twig', [
            'input_saisis' => $safe ?? [], // Me permet de reprendre mes données déjà saisies dans la vue
        ]);
    } // Fin function signIn


    // private function verifForm($superglobale, $champs)
    // {
    //     // Fonction universelle de vérification de formulaire
    //     // Boucler sur "champs"
    //     foreach ($champs as $champ) {
    //         // Vérifier si le champ existe et si le champ n'est pas vide
    //         if (isset($superglobale[$champ]) && !empty($superglobale[$champ])) {
    //             $reponse = true;
    //         }
    //         // Sinon retourner false
    //         else {
    //             return false;
    //         }
    //     }
    //     // Envoyer la réponse "return"
    //     return $reponse;
    // } // Fin verifform
}
