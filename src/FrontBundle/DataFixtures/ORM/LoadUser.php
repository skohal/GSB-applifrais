<?php

namespace FrontBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FrontBundle\Entity\user;

class LoadUser extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $date = new \DateTime();

        $tab = array(
            array(
                'nom' => 'Dupin',
                'prenom' => 'Jacques-Admin',
                'email' => 'yolo@email.com',
                'user' => 'admin',
                'password' => 'admin',
                'role' => '[ROLE_ADMIN]',
                'adresse' => '3 rue Dupin',
                'cp' => '69001',
                'ville' => 'Lyon',
            )
        );

        foreach($tab as $row) {
            $user = new user();
            $user->setEmail($row['email']);
            $user->setNom($row['nom']);
            $user->setPrenom($row['prenom']);
            $user->setUsername($row['user']);
            $user->setPlainPassword($row['password']);
            $user->setRoles(array('ROLE_ADMIN'));
            $user->setAdresse($row['adresse']);
            $user->setCp($row['cp']);
            $user->setVille($row['ville']);
            $user->setEnabled(true);
            $user->setDateEmbauche($date->setDate(2012, 4, 27));

            $manager->persist($user);
        }
        $manager->flush();
    }
}