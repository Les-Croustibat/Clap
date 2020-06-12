<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User; // J'appelle l'entity dans laquelle je vais enregistrer mes données => correspond à une table SQL

/**
* Require ROLE_ADMIN for *every* controller method in this class.
*
* @IsGranted("ROLE_ADMIN")
*/
class AdminController extends AbstractController
{

    public function adminDashboard()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Un utilisateur a voulu se connecter sans être [\'ROLE_ADMIN\']');

    }

    public function list()
    {
        // On accède au manager (connexion DB)
        $entityManager = $this->getDoctrine()->getManager();
        // On précise dans quelle table on veut agir via le repository et on execute la fonction
        $users_in_db = $entityManager->getRepository(User::class)->findAll();

        return $this->render('admin/users_list.html.twig', [
            'users' => $users_in_db,
        ]);
    }

    public function view(int $id)
    {
        // On accède au manager (connexion DB)
        $entityManager = $this->getDoctrine()->getManager();
        // On précise dans quelle table on veut agir via le repository et on execute la fonction
        $users_in_db = $entityManager->getRepository(User::class)->find($id);

        return $this->render('admin/users_view.html.twig', [
            'user' => $users_in_db,
        ]);
    }

    public function suppr(int $id)
    {
        // On accède au manager (connexion DB)
        $entityManager = $this->getDoctrine()->getManager();
        // On précise dans quelle table on veut agir via le repository et on execute la fonction
        $user_in_db = $entityManager->getRepository(User::class)->find($id);

        if (!empty($_POST)) {
            if (isset($_POST['action']) && $_POST['action'] === 'delete') {

                // Suppression
                $entityManager->remove($user_in_db);
                $entityManager->flush();

                $this->addFlash('success', 'L\'utilisateur a bien été supprimé');
                return $this->redirectToRoute('admin_list');
            }
        }

        return $this->render('admin/users_suppr.html.twig', [
            'user' => $user_in_db,
        ]);
    }
}