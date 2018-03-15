<?php

namespace FrontBundle\Controller;

use FrontBundle\Entity\FicheFrais;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;



class FicheFraisController extends Controller
{

    public function gererFichesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ficheFrais = $em->getRepository('FrontBundle:FicheFrais')->findAll();

        return $this->render('@Front/Admin/Gererfichesfrais.html.twig', array(
            'ficheFrais' => $ficheFrais,
        ));
    }


    public function voirFicheFraisAction(FicheFrais $ficheFrai, $id)
    {
        $fiche = $this->getDoctrine()->getRepository('FrontBundle:FicheFrais')->find($id);
        $em = $this->getDoctrine()->getManager();

        $fraisForfaits = $fiche->getFraisForfaits();
        $fraisHorsForfaits = $fiche->getFraisHorsForfaits();
        $tousFraisValidés = true;
        $etatValidé = $em->getRepository("FrontBundle:Etat")->find(3);
        $etatCloturé = $em->getRepository("FrontBundle:Etat")->find(2);

        foreach($fraisForfaits as $frais) {
            if ($frais->getEtat()->getId() < 3){
                $tousFraisValidés = false;
            }
        }

        foreach($fraisHorsForfaits as $frais) {
            if ($frais->getEtat()->getId() < 3){
                $tousFraisValidés = false;
            }
        }

        if ($tousFraisValidés==true && $fiche->getEtat()->getId()==2){
            $fiche->setEtat($etatValidé);
            $em->persist($fiche);
            $em->flush();
        } else {
            if ($fiche->getEtat()->getId()==3) {
                $fiche->setEtat($etatCloturé);
                $em->persist($fiche);
                $em->flush();
            }
        }

        return $this->render('FrontBundle:Admin:voirfichefrais.html.twig', array(
            'ficheFrai' => $ficheFrai,
        ));
    }
}
