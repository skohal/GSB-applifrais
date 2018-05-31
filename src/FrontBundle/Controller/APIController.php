<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;


class APIController extends Controller
{

    /*Action d'ajoute d'uilisateur */


    /*Action de connection utilisateur*/

    public function connexionAPIaction(request $request)
    {


        $username= $request->get("username");
        $password= $request->get("password");
        $status = false;
        $data = "";


        $user = $this->getDoctrine()->getRepository('FrontBundle:user')->findOneBy($username);


        if ($user) {
            $encoder_service = $this->get('security.encoder_factory');
            $encoder = $encoder_service->getEncoder($user);
            $status = $encoder->isPasswordValid(
                $user->getPassword(),
                $password,
                $user->getSalt()
            );

            if ($status) {
                $token = new UsernamePasswordToken($user, $user->getPassword(), 'main', $user->getRoles());

                $context = $this->get('security.token_storage');
                $context->setToken($token);

                $data = $user->getId();
            } else {
                $data = "Refusé";
            }
        }else {
            $data = "Utilisateur inconnu";
        }

        $response = new JsonResponse();
        $response->setData(array(
            'status' => $status,
            'data' => $data
        ));

        return $response;


      /*  $em = $this->getDoctrine()->getManager();

        $users =$em->getRepository('FrontBundle:user')->findAll();


        $jsonContent = array();
        $lesusers = array();


        foreach ($users as $unuser){
            $leuser = array();
            $leuser["prenom"] = $unuser->getPrenom();
            $leuser["nom"] = $unuser->getNom();
            $leuser["username"] = $unuser->getUsername();
            $leuser["id"] = $unuser->getId();
            $leuser["password"] = $unuser->getPassword();
            $leuser["role"] = $unuser->getRoles();



            array_push($lesusers, $leuser);
        }

        $jsonContent["lesutilisateur"] = $lesusers;
        return new JsonResponse(
            array("status" => "ok",
                "data" => $jsonContent)
        );

      */
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
