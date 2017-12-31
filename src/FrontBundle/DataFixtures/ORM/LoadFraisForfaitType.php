<?php

namespace FrontBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FrontBundle\Entity\FraisForfaitType;


class LoadFraisForfaitType extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $tab = array(
            array('libelle'=>'Nuitée Hôtel', 'montant'=>'80'),
            array('libelle'=>'Repas restaurant', 'montant'=>'25'),
            array('libelle'=>'Forfait kilométrique', 'montant'=>'0.62')
        );

        foreach($tab as $row) {
            $fraisForfaitType = new FraisForfaitType();
            $fraisForfaitType->setLibelle($row['libelle']);
            $fraisForfaitType->setMontant($row['montant']);

            $manager->persist($fraisForfaitType);
        }
        $manager->flush();
    }
}