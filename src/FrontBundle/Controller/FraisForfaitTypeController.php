<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FrontBundle\Entity\FraisForfaitType;
use Symfony\Component\HttpFoundation\Request;

class FraisForfaitTypeController extends Controller
{
    public function addFraisForfaitTypeAction(Request $request)
    {
        $fraisforfaittype = new fraisForfaitType();
        $formfft = $this->createForm('FrontBundle\Form\FraisForfaitTypeType', $fraisforfaittype);
        $formfft->handleRequest($request);

        if ($formfft->isSubmitted() && $formfft->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fraisforfaittype);
            $em->flush();
            $this->addFlash('success','Frais ajouté');
        }

        return $this->render('FrontBundle:Admin:addfraistype.html.twig',
            array('formfft' => $formfft->createView()));

    }
}
