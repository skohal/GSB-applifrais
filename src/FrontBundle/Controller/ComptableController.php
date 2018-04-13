<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ComptableController extends Controller
{
    /* Action qui affiche la liste des fiche frais pour la gestion admin*/

    public function gererFichesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $ficheFrais = $em->getRepository('FrontBundle:FicheFrais')->findAll();

        return $this->render('@Front/Comptable/Gererfichesfrais.html.twig', array(
            'ficheFrais' => $ficheFrais,
        ));
    }

    /* Action qui permet à l'admin de des gerer l'etat des frais d'une fiche*/

    public function voirFicheFraisAction($id)
    {

        $fiche = $this->getDoctrine()->getRepository('FrontBundle:FicheFrais')->find($id);
        $em = $this->getDoctrine()->getManager();

        $fraisForfaits = $fiche->getFraisForfaits();
        $fraisHorsForfaits = $fiche->getFraisHorsForfait();
        $tousFraisValides = true;
        $etatvalide = $em -> getRepository('FrontBundle:Etat')-> find(3);
        $etatCloture = $em -> getRepository('FrontBundle:Etat') -> find(2);

        foreach ($fraisForfaits as $frais){
            if ($frais ->getEtat() -> getId() < 3){
                $tousFraisValides = false;
            }
        }

        foreach ($fraisHorsForfaits as $frais){
            if ($frais -> getEtat() -> getId() < 3){
                $tousFraisValides = false;
            }
        }

        if($tousFraisValides == true && $fiche -> getEtat() -> getId() == 2) {
            $fiche -> setEtat($etatvalide);
            $em -> persist($fiche);
            $em -> flush();
        } else {
            if ($fiche->getEtat() -> getId ()==3){
                $fiche -> setEtat($etatCloture);
                $em -> persist($fiche);
                $em -> flush();
            }
        }

        return $this->render('FrontBundle:Comptable:voirfichefrais.html.twig',
            array(
                "fichefrais" => $fiche,
                "fraisForfaits" => $fraisForfaits,
                "fraisHorsForfaits" => $fraisHorsForfaits
            ));

    }

    /* Action qui permet a l'admin de supprmier une fiche frais*/

    public function supprFicheFraisAction($id)
    {
        $fichefrais = $this->getDoctrine()->getRepository("FrontBundle:FicheFrais")->find($id);

        if ($fichefrais != null) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fichefrais);
            $em->flush();
        }
        return $this->redirectToRoute('gererfichesfrais');
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
