<?php

namespace FrontBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\DateTimeParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use FrontBundle\Entity\FicheFrais;
use FrontBundle\Entity\FraisForfait;
use FrontBundle\Entity\FraisForfaitType;
use FrontBundle\Entity\FraisHorsForfait;



class FraisController extends Controller
{
    public function addFraisAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();


        $moisEnCours = (new \DateTime())->format('m');
        $anneeEnCours = (new \DateTime())->format('Y');
        $jourEnCours = (new \DateTime())->format('d');

        $moisFicheFrais = $moisEnCours;
        $anneeFicheFrais = $anneeEnCours;
        if ($jourEnCours>10){
            $moisFicheFrais=($moisEnCours + 1);
            if ($moisFicheFrais >12) {
                $moisFicheFrais=1;
                $anneeFicheFrais = ($anneeEnCours +1);
            }
        }

        $ficheFraisEnCours = $this->getDoctrine()->getRepository("FrontBundle:FicheFrais")->findOneBy(
            array("mois" => $moisFicheFrais,
                "annee" => $anneeFicheFrais,
                "user" => $user)
        );


        if($ficheFraisEnCours == null){
            $etat = $em->getRepository('FrontBundle:Etat')->find(1);

            $ficheFraisEnCours = new ficheFrais();
            $ficheFraisEnCours->setMois($moisFicheFrais);
            $ficheFraisEnCours->setAnnee($anneeFicheFrais);
            $ficheFraisEnCours->setEtat($etat);
            //synchron entre fiche<=>user
            $user->addFiche($ficheFraisEnCours);
            $ficheFraisEnCours->setUser($user);
        }

        $fraisforfait = new fraisForfait();
        $etatInitial = $em->getRepository("FrontBundle:Etat")->find(1);
        $fraisforfait->setEtat($etatInitial);
        $fraisforfait->setDate(new \DateTime());
        $formforfait = $this ->createForm('FrontBundle\Form\FraisForfaitType', $fraisforfait);
        $formforfait->handleRequest($request);


        if ($formforfait->isSubmitted() && $formforfait->isValid()) {
            $ficheFraisEnCours->addFraisForfait($fraisforfait);
            $fraisforfait->setFiche($ficheFraisEnCours);
            $em->persist($user);
            $em->flush();
            $this->addFlash("success", "Frais ajouté avec succès");
        }

        $fraisHorsforfait = new fraisHorsForfait();
        $fraisHorsforfait->setEtat($etatInitial);
        $fraisHorsforfait->setDate(new \DateTime());
        $formHorsforfait = $this ->createForm('FrontBundle\Form\FraisHorsForfaitType', $fraisHorsforfait);
        $formHorsforfait->handleRequest($request);

        if ($formHorsforfait->isSubmitted() && $formHorsforfait->isValid()) {
            $ficheFraisEnCours->addFraisHorsForfait($fraisHorsforfait);
            $fraisHorsforfait->setFiche($ficheFraisEnCours);
            $em->persist($user);
            $em->flush();
            $this->addFlash("success", "Frais hors forfait ajouté avec succès");
        }

        return $this->render("@Front/Utilisateur/addFrais.html.twig",
            array(
                'formforfait' => $formforfait->createView(),
                'formHorsforfait' => $formHorsforfait->createView(),
                'jour'=>$jourEnCours,
                'mois'=>$moisEnCours,
                'annee'=>$anneeEnCours,
                'fichefraisencours' => $ficheFraisEnCours,
            ));
    }
    }
