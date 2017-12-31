<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use FrontBundle\Entity\Etat;
use FrontBundle\Entity\FraisForfaitType;
use FrontBundle\Entity\user;




class DataDefaultController extends Controller
{

    public function creatDataAction()
    {
        $em = $this->getDoctrine()->getManager();
        $date = new \DateTime();

        $etat = new Etat();
        $etat->setId('1');
        $etat->setLibelle('Fiche créée, saisie en cours');
        $em->persist($etat);
        $em->flush();

        $etat = new Etat();
        $etat->setId('2');
        $etat->setLibelle('Saisie cloturée');
        $em->persist($etat);
        $em->flush();

        $etat = new Etat();
        $etat->setId('3');
        $etat->setLibelle('Validée');
        $em->persist($etat);
        $em->flush();

        $forfaitType = new FraisForfaitType();
        $forfaitType->setLibelle('Nuitée Hôtel');
        $forfaitType->setMontant('80');
        $em->persist($forfaitType);
        $em->flush();

        $forfaitType = new FraisForfaitType();
        $forfaitType->setLibelle('Repas restaurant');
        $forfaitType->setMontant('25');
        $em->persist($forfaitType);
        $em->flush();

        $forfaitType = new FraisForfaitType();
        $forfaitType->setLibelle('Forfait kilométrique');
        $forfaitType->setMontant('0.62');
        $em->persist($forfaitType);
        $em->flush();

        $user = new User();
        $user->setNom('Dupin');
        $user->setPrenom('Jacques-Admin');
        //$user->setUsername('admin');
        //$user->setPassword('admin');
        //$user->setRoles('ROLE_ADMIN');
        $user->setAdresse('3 rue Dupin');
        $user->setCp('69001');
        $user->setVille('Lyon');
        $user->setDateEmbauche($date->setDate(2012, 4, 27));
        $em->persist($user);
        $em->flush();

        return new Response('<html><h5>Vous avez bien créé les états, les forfaits types et un admin (admin, admin)</h5></html>');
    }


}
