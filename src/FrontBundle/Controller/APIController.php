<?php

namespace FrontBundle\Controller;

use FrontBundle\Entity\FraisForfait;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FrontBundle\Entity\user;
use FrontBundle\Entity\FraisForfaitType;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class APIController extends Controller
{

    /*Action d'ajoute d'uilisateur */


    /*Action de connection utilisateur*/

    public function connexionAPIaction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $users =$em->getRepository('user')->find($id);


    }

    /*Action d'affichage de la liste des utilisateur */

    public function listeFichesAPIAction($idUser)
    {
        $em = $this->getDoctrine()->getManager();

        $fiches = $em->getRepository('FrontBundle:FicheFrais')->findByUser($idUser);
/*
                $normalizer = new ObjectNormalizer();
                $normalizer->setCircularReferenceLimit(1);
        // Add Circular reference handler
                $normalizer->setCircularReferenceHandler(function ($object) {
                    return null;
                });
                $normalizers = array($normalizer);
                $encoders = array(new XmlEncoder(), new JsonEncoder());

                $serializer = new Serializer($normalizers, $encoders);
                $jsonContent = $serializer->serialize($fiches, 'json');
*/
        $jsonContent = array();
        $lesfiches = array();


        foreach ($fiches as $unefiche){
            $lafiche = array();
            $lafiche["id"] = $unefiche->getId();
            $lafiche["mois"] = $unefiche->getMois();
            $lafiche["montantValide"] = $unefiche->getMontantValide();


            array_push($lesfiches, $lafiche);
        }

        $jsonContent["lesfiches"] = $lesfiches;
        return new JsonResponse(
            array("status" => "ok",
                "data" => $jsonContent)
        );
    }

    /* Action qui affiche les frais de la fiche selectionnée */

    public function FicheAPIAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $fiche = $em->getRepository('FrontBundle:FicheFrais')->find($id);

        $jsonContent = array();
        $jsonContent["id"] = $fiche->getId();
        $jsonContent["mois"] = $fiche->getMois();
        $jsonContent["annee"] = $fiche->getAnnee();
        $jsonContent["montantValide"] = $fiche->getMontantValide();
        $jsonContent["montantTotal"] = $fiche->getMontantTotal();
        $fraisForfaitsData = $fiche->getFraisForfaits();
        $fraisHorsForfaitsData = $fiche->getFraisHorsForfait();
        $fraisForfaits = array();
        $fraisHorsForfaits = array();

        foreach ($fraisForfaitsData as $frais){
            $unFrais = array();
            $unFrais["idFrais"] = $frais->getId();
            $unFrais["date"] = $frais->getDate()->format("d-m-Y");
            $unFrais["libelle"] = $frais->getFraisType()->getLibelle();
            $unFrais["montant"] = $frais->getFraisType()->getMontant();
            $unFrais["quantite"] = $frais->getQuantite();
            $unFrais["montanttotal"] = $frais->getMontant();
            $unFrais["etat"] = $frais->getEtat()->getLibelle();

            array_push($fraisForfaits, $unFrais);
        }

        foreach ($fraisHorsForfaitsData as $frais){
            $unFrais = array();
            $unFrais["idFrais"] = $frais->getId();
            $unFrais["date"] = $frais->getDate()->format("d-m-Y");
            $unFrais["libelle"] = $frais->getLibelle();
            $unFrais["quantite"] = $frais->getQuantite();
            $unFrais["montant"] = $frais->getMontant();
            $unFrais["montanttotal"] = $frais->getMontantTotal();
            $unFrais["etat"] = $frais->getEtat()->getLibelle();

            array_push($fraisHorsForfaits, $unFrais);
        }

        $jsonContent["fraisForfaits"] = $fraisForfaits;
        $jsonContent["fraisHorsForfaits"] = $fraisHorsForfaits;
        return new JsonResponse(
            array("status" => "ok",
                "data" => $jsonContent)
        );
    }


}
