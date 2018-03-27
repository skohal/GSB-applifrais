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

    /*Action permet d'affiché les formulaires d'ajoute de frais forfait et hors forfait pour l'utilisateur */

    public function addFraisAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();


        $moisEnCours = (new \DateTime())->format('m');
        $anneeEnCours = (new \DateTime())->format('Y');
        $jourEnCours = (new \DateTime())->format('d');

        $moisFicheFrais = $moisEnCours;
        $anneeFicheFrais = $anneeEnCours;
        if ($jourEnCours > 10) {
            $moisFicheFrais = ($moisEnCours + 1);
            if ($moisFicheFrais > 12) {
                $moisFicheFrais = 1;
                $anneeFicheFrais = ($anneeEnCours + 1);
            }
        }

        $ficheFraisEnCours = $this->getDoctrine()->getRepository("FrontBundle:FicheFrais")->findOneBy(
            array("mois" => $moisFicheFrais,
                "annee" => $anneeFicheFrais,
                "user" => $user)
        );


        if ($ficheFraisEnCours == null) {
            $etatId = $em->getRepository('FrontBundle:Etat')->find(1);

            $ficheFraisEnCours = new ficheFrais();
            $ficheFraisEnCours->setMois($moisFicheFrais);
            $ficheFraisEnCours->setAnnee($anneeFicheFrais);
            $ficheFraisEnCours->setEtat($etatId);
            //synchron entre fiche<=>user
            $user->addFiche($ficheFraisEnCours);
            $ficheFraisEnCours->setUser($user);
        }

        $fraisforfait = new fraisForfait();
        $etatInitial = $em->getRepository("FrontBundle:Etat")->find(1);
        $fraisforfait->setEtat($etatInitial);
        $fraisforfait->setDate(new \DateTime());
        $formforfait = $this->createForm('FrontBundle\Form\FraisForfaitType', $fraisforfait);
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
        $formHorsforfait = $this->createForm('FrontBundle\Form\FraisHorsForfaitType', $fraisHorsforfait);
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
                'jour' => $jourEnCours,
                'mois' => $moisEnCours,
                'annee' => $anneeEnCours,
                'fichefraisencours' => $ficheFraisEnCours,
            ));
    }

    /*Action qui permet a l'utilisateur de se supprimer un frais forfait rentré sur la page d'ajoute */

    public function supprimerfraisforfaitAction($id)
    {

        $fraisforfait = $this->getDoctrine()->getRepository('FrontBundle:FraisForfait')->find($id);

        if ($fraisforfait != null) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fraisforfait);
            $em->flush();
            $this->addFlash("success", "Frais supprimer");
        }
        return $this->redirectToRoute('addfrais');


    }

    /*Action qui permet a l'utilisateur de se supprimer un frais hors forfait rentré sur la page d'ajoute */

    public function suppfraishorsforfaitAction($id)
    {

        $fraisHorsforfait = $this->getDoctrine()->getRepository('FrontBundle:FraisHorsForfait')->find($id);

        if ($fraisHorsforfait != null) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fraisHorsforfait);
            $em->flush();
            $this->addFlash("success", "Frais supprimer");
        }
        return $this->redirectToRoute('addfrais');


    }

    public function validerfraisforfaitAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $fraisforfait = $this->getDoctrine()->getRepository('FrontBundle:FraisForfait')->find($id);
        $etatValide = $em->getRepository("FrontBundle:Etat")->find(3);

        $fraisforfait->setEtat($etatValide);
        $em->persist($fraisforfait);
        $em->flush();
        $ficheId = $fraisforfait->getFiche()->getId();


        $this->addFlash("success", "Frais forfait validé");
        return $this->redirectToRoute('voirfichefrais', array('id' => $ficheId));
    }

    public function refuserfraisforfaitAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $fraisforfait = $this->getDoctrine()->getRepository('FrontBundle:FraisForfait')->find($id);
        $etatInitial = $em->getRepository("FrontBundle:Etat")->find(2);
        $fraisforfait->setEtat($etatInitial);
        $em->persist($fraisforfait);
        $em->flush();
        $ficheId = $fraisforfait->getFiche()->getId();

        $this->addFlash("success", "Frais forfait rétabli");
        return $this->redirectToRoute('voirfichefrais', array('id' => $ficheId));
    }

    public function validerfraishorsforfaitAction($id)
    {


        $em = $this->getDoctrine()->getManager();

        $fraishorsforfait = $this->getDoctrine()->getRepository('FrontBundle:FraisHorsForfait')->find($id);
        $etatValide = $em->getRepository("FrontBundle:Etat")->find(3);
        $fraishorsforfait->setEtat($etatValide);

        $em->persist($fraishorsforfait);
        $em->flush();
        $ficheId = $fraishorsforfait->getFiche()->getId();



        $this->addFlash("success", "Frais hors forfait validé");
        return $this->redirectToRoute('voirfichefrais', array('id' => $ficheId));
    }

    public function refuserfraishorsforfaitAction($id)
    {


        $em = $this->getDoctrine()->getManager();
        $fraishorsforfait = $this->getDoctrine()->getRepository('FrontBundle:FraisHorsForfait')->find($id);
        $etatInitial = $em->getRepository("FrontBundle:Etat")->find(2);
        $fraishorsforfait->setEtat($etatInitial);
        $em->persist($fraishorsforfait);
        $em->flush();
        $ficheId = $fraishorsforfait->getFiche()->getId();

        $this->addFlash("success", "Frais hors forfait rétabli");
        return $this->redirectToRoute('voirfichefrais', array('id' => $ficheId));
    }

}