<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FrontBundle\Entity\FraisForfaitType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class FraisForfaitTypeController extends Controller
{
    /*Action permet a l'admin d'ajoute de nouveaux frais forfait Type a la liste et d'afficher la liste */

    public function addFraisForfaitTypeAction(Request $request)
    {
        $em = $this -> getDoctrine()->getManager();
        $fraisType = $em->getRepository("FrontBundle:FraisForfaitType")->findAll();

        $fraisforfaittype = new fraisForfaitType();
        $formfft = $this->createForm('FrontBundle\Form\FraisForfaitTypeType', $fraisforfaittype);
        $formfft ->add("Ajouter", SubmitType::class, array(
            'attr'  => array('class' => 'btn','center-align')));
        $formfft->handleRequest($request);

        if ($formfft->isSubmitted() && $formfft->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fraisforfaittype);
            $em->flush();
            $this->addFlash('success','Frais ajouté');

            return $this->redirectToRoute('addfraistype');

        }
        return $this->render('@Front/Admin/addfraistype.html.twig',
            array('formfft' => $formfft->createView(),
                "fraisType" => $fraisType

            ));

    }

    /*Action permet a l'admin de supprimer un frais type de la liste */

    public function removeFraisTypeAction($id)
    {
        $listeforfaittype = $this->getDoctrine()->getRepository('FrontBundle:FraisForfaitType')->find($id);

        if ($listeforfaittype != null) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($listeforfaittype);
            $em->flush();
            $this->addFlash("success", "Frais type supprimer");
        }
        return $this->redirectToRoute('addfraistype',array());
    }
}
