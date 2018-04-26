<?php

namespace FrontBundle\Controller;

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


    /*Action d'affichage de la liste des utiliasteur */

    public function listeFichesAPIAction($idUser)
    {
        $em = $this->getDoctrine()->getManager();

        $fiches = $em->getRepository('FrontBundle:FicheFrais')->findByUser($idUser);

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
// Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($fiches, 'json');

        return new JsonResponse(
            array("status" => "ok",
            "data" => $jsonContent)
        );
    }


}
