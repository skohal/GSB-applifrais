<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use FrontBundle\Entity\FicheFrais;
use FrontBundle\Entity\FraisForfait;
use FrontBundle\Entity\FraisHorsForfait;

class UtilisateurController extends Controller
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
        if ($jourEnCours > 10) {
            $moisFicheFrais = ($moisEnCours ++);
            if ($moisFicheFrais > 12) {
                $moisFicheFrais = 1;
                $anneeFicheFrais = ($anneeEnCours ++);
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
        $formforfait->add("Ajouter", SubmitType::class, array(
            'attr'  => array('class' => 'btn','center-align')));
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
        $formHorsforfait->add("Ajouter", SubmitType::class, array(
            'attr'  => array('class' => 'btn','center-align')));
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

        /* Action qui affiche sa liste de fiche*/

        public function listeficheAction(Request $request)
    {
        $user = $this->getUser();

        $ficheFrais = $user->getFiche();

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
        $formforfait->add("Modifier", SubmitType::class, array(
            'attr'  => array('class' => 'btn','center-align')));
        $formforfait ->handleRequest($request);

        if($formforfait->isSubmitted()&& $formforfait->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('afficherfichefrais',array('id' => $fraisforfait ->getFiche()->getId()));
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
        $formhorsforfait->add("Modifier", SubmitType::class, array(
            'attr'  => array('class' => 'btn','center-align')));
        $formhorsforfait->handleRequest($request);


        if($formhorsforfait->isSubmitted()&& $formhorsforfait->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('afficherfichefrais', array('id'=>$fraishorsforts->getFiche()->getId()));

        }
        return $this->render('@Front/Utilisateur/modifierfraishorsforfait.html.twig',
            array('formHorsforfait' => $formhorsforfait->createView(),
                "referer" => $referer));
    }
}
