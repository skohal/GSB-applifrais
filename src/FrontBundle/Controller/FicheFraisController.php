<?php

namespace FrontBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FicheFraisController extends Controller
{

    /* Action qui affiche la liste des fiche frais pour la gestion admin*/

    public function gererFichesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $ficheFrais = $em->getRepository('FrontBundle:FicheFrais')->findAll();

        return $this->render('@Front/Admin/Gererfichesfrais.html.twig', array(
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

        return $this->render('FrontBundle:Admin:voirfichefrais.html.twig',
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

    /* Action qui affiche sa liste de fiche*/

    public function listeficheAction()
    {
        $em = $this->getDoctrine()->getManager();
        $ficheFrais = $em->getRepository('FrontBundle:FicheFrais')->findAll();

        return $this->render('FrontBundle:Utilisateur:listefrais.html.twig', array(
            'ficheFrais' => $ficheFrais,
        ));
    }

    /* Action qui affiche la fiche de frais de l'utilisateur avec tous les frais rentés */

    public function afficherficheAction($id)
    {
        $ficheutilisateur = $this->getDoctrine()->getRepository('FrontBundle:FicheFrais')->find($id);




        return $this->render("@Front/Utilisateur/afficherfrais.html.twig",array(
            'ficheutilisateur' => $ficheutilisateur
                     ));

    }

    /* Action qui permet de modifier un frais rentré pour l'utilisateur */

    public function modifierfraisforfaitAction(request $request, $id)
    {
        $referer = $request->headers->get('referer');

        $fraisforfait = $this->getDoctrine()->getRepository('FrontBundle:FraisForfait')->find($id);
        $formforfait = $this->createForm('FrontBundle\Form\FraisForfaitType',$fraisforfait);
        $formforfait ->handleRequest($request);
        $fraisforfait->getId();

        if($formforfait->isSubmitted()&& $formforfait->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('afficherfichefrais');
        }
        return $this->render('@Front/Utilisateur/modifierfraisforfait.html.twig',
            array('formforfait' => $formforfait->createView(),
            "referer" => $referer));
    }

    /*Action qui permet de modifier un frais hors forfait rentré par l'utilisateur */

    public function modifierfraishorsforfaitAction(request $request, $id)
    {
        $referer = $request->headers->get('referer');

        $fraishorsforts = $this->getDoctrine()->getRepository('FrontBundle:FraisHorsForfait')->find($id);
        $formhorsforfait = $this->createForm('FrontBundle\Form\FraisHorsForfaitType',$fraishorsforts);
        $formhorsforfait->handleRequest($request);
        $fraishorsforts->getId();

        if($formhorsforfait->isSubmitted()&& $formhorsforfait->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('afficherfichefrais');
        }
        return $this->render('@Front/Utilisateur/modifierfraishorsforfait.html.twig',
            array('formHorsforfait' => $formhorsforfait->createView(),
                "referer" => $referer));
    }
}

