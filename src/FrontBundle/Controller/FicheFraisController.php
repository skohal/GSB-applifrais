<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;



class FicheFraisController extends Controller
{
    public function removeFicheFraisAction(Request $request, $id)
    {

        $fichefrais = $this->getDoctrine()->getRepository('FrontBundle:FicheFrais')->find($id);

        if ($fichefrais != null) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fichefrais);
            $em->flush();
        }
        return $this->redirectToRoute('gererfichesfrais');
    }

    public function voirFicheFraisAction(Request $request, $id)
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

        return $this->render('@Front/Admin/Gererfichesfrais.html.twig',
            array(
                "fichefrais" => $fiche,
            ));
    }

    public function listeFichesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $fichesFrais = $user->getFiches();
        $fraisForfaits = $this->getDoctrine()->getRepository('FrontBundle:FraisForfait')->findAll();
        $fraisHorsForfaits = $this->getDoctrine()->getRepository('FrontBundle:FraisHorsForfait')->findAll();


        return $this->render('@Front/Admin/Gererfichesfrais.html.twig',
            array('fichesfrais' => $fichesFrais,
                'fraisforfaits' => $fraisForfaits,
                'fraishorsforfaits' => $fraisHorsForfaits
            ));
    }

    public function gererFichesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $fichesFrais = $this->getDoctrine()->getRepository('FrontBundle:FicheFrais')->findAll();
        $fraisForfaits = $this->getDoctrine()->getRepository('FrontBundle:FraisForfait')->findAll();
        $fraisHorsForfaits = $this->getDoctrine()->getRepository('FrontBundle:FraisHorsForfait')->findAll();


        return $this->render('@Front/Admin/Gererfichesfrais.html.twig',
            array('fichesfrais' => $fichesFrais,
                'fraisforfaits' => $fraisForfaits,
                'fraishorsforfaits' => $fraisHorsForfaits
            ));
    }
}
