<?php

namespace FrontBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FrontBundle\Entity\Etat;


class LoadEtat extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $libelles = array(
            'Fiche créée, saisie en cours','Saisie cloturée','Validée'
        );

        foreach($libelles as $libelle) {
            $etat = new Etat();
            $etat->setLibelle($libelle);

            $manager->persist($etat);
        }
        $manager->flush();
    }
}