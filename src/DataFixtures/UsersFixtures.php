<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class UsersFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {       
            // Création du ROLE_ADMIN
            $admin = new User();
            $admin->setEmail('contact@clap.fr');
            $admin->setRoles(['ROLE_ADMIN']);
            $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            'toto'
            ));
            $admin->setFirstname('La');
            $admin->setLastname('Team');
            $admin->setPseudo('Croustibat');

            $manager->persist($admin);

            // Instancie un Faker pour créer des faux users
            $faker = \Faker\Factory::create('fr_FR');

            // Boucle pour créer des utilisateurs fakes
            for ($i = 0; $i < 10; $i++) {
               $user = new User();
   
               $user->setEmail($faker->email);
               $user->setRoles(['ROLE_USER']);
               $user->setPassword($this->passwordEncoder->encodePassword(
                   $user,
                   'azerty' // Ici c'est le mot de passe en clair de mes utilisateurs tests
               ));
               $user->setFirstname($faker->firstname);
               $user->setLastname($faker->lastname);
               $user->setPseudo($faker->username);
   
               $manager->persist($user);
            }
        
        $manager->flush();
    }
}
