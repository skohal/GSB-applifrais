<?php

namespace FrontBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

use FrontBundle\Entity\FraisForfait;

use FrontBundle\Entity\FraisHorsForfait;


class FraisController extends Controller
{
    public function addFraisAction(Request $request)
    {
        $fraisforfait = new FraisForfait();
        $formforfait = $this ->createForm('FrontBundle\Form\FraisForfaitType', $fraisforfait);
        $formforfait->handleRequest($request);

        if ($formforfait->isSubmitted() && $formforfait->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fraisforfait);
            $em->flush();
        }

        $fraishorsforfait = new FraisHorsForfait();
        $formHorsforfait = $this ->createForm('FrontBundle\Form\FraisHorsForfaitType', $fraishorsforfait);
        $formHorsforfait->handleRequest($request);

        if ($formHorsforfait->isSubmitted() && $formHorsforfait->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fraishorsforfait);
            $em->flush();
        }





        return $this->render('FrontBundle:Utilisateur:addfrais.html.twig', array('formforfait' => $formforfait->createView(),
        'formHorsforfait' => $formHorsforfait ->createView()));





    }





    //  $em = $this->getDoctrine()->getManager();
    //   $user = $this->getUser();

        //    $jourEnCours = (new \DateTime())->format('d');
        //    $moisEnCours = (new \DateTime())->format('m');
        //    $anneeEnCours = (new \DateTime())->format('y');

        //    $moisFicheFrais = $moisEnCours;
        //    $anneeFicheFrais = $anneeEnCours;
        //    if ($jourEnCours > 10) {
        //        $moisFicheFrais = ($moisEnCours + 1);
        //        if ($moisFicheFrais > 12) {
        //           $moisFicheFrais = 1;
        //           $anneeFicheFrais = ($anneeEnCours + 1);
        //       }
        //   }

        //   $fichesFrais = $user->getFiches();
        //    $ficheFrais = null;
        //   $ficheFraisEnCours = null;
        //    foreach ($fichesFrais as $uneFicheFrais){
            //       if ($uneFicheFrais->getMois() == $moisFicheFrais && $uneFicheFrais->getAnnee() == $anneeFicheFrais) {
        //            $ficheFrais = $uneFicheFrais;
        //           $ficheFraisEnCours = $uneFicheFrais;
        //       }
        //   }

        // $etatId = $this -> getDoctrine() -> getRepository('FrontBundle:Etat') ->find(1);
        //if($ficheFrais == null) {
        //    $ficheFrais = new FicheFrais();
        //    $ficheFrais->setMois($moisFicheFrais);
        //   $ficheFrais->setAnnee($anneeFicheFrais);
        //   $ficheFrais->setEtat($etatId);
        //   $user->addFiche($ficheFrais);
        //}

        //$fraisforfait = new FraisForfait();
        //$fraisForfaits = $this -> getDoctrine() ->getRepository('FrontBundle:FraisForfait') ->findAll();
        //$formforfait = $this->createForm('FrontBundle\Form\FraisForfaitType', $fraisforfait);
        //$formforfait->handleRequest($request);

        //$etatInitial = $em->getRepository('FrontBundle:Etat') ->find(1);
        //$fraisforfait->setEtat($etatInitial);

        //if ($formforfait->isSubmitted() && $formforfait->isValid()) {
        //    $ficheFrais->addFraisForfait($fraisforfait);
        //   $em->persist($user);
        //   $em->flush();
        //   $this->addFlash("success", "Frais ajouté avec succès");
        //}

        //$fraisHorsforfait = new FraisHorsForfait();
        //$fraisHorsForfaits = $this->getDoctrine()->getRepository('FrontBundle:FraisHorsForfait')->findAll();
        //$formHorsforfait = $this->createForm('FrontBundle\Form\FraisHorsForfaitType', $fraisHorsforfait);
        //$formHorsforfait->handleRequest($request);

        //$fraisHorsforfait->setEtat($etatInitial);

        //if ($formHorsforfait->isSubmitted() && $formHorsforfait->isValid()) {
        //    $ficheFrais->addFraisHorsForfait($fraisHorsforfait);
        //    $em->persist($user);
        //    $em->flush();
        //   $this->addFlash("success", "Frais hors forfait ajouté avec succès");
        //}

        //return this->$this->redirectToRoute('test_homepage');
        //return $this->render("@Front/Utilisateur/addfrais.html.twig",
        //    array('formforfait' => $formforfait->createView(),
        //        'formHorsforfait' => $formHorsforfait->createView(),
        //        'fraisforfaits' => $fraisForfaits,
        //        'fraishorsforfaits' => $fraisHorsForfaits,
        //      'jour'=>$jourEnCours,
        //        'mois'=>$moisEnCours,
        //       'annee'=>$anneeEnCours,
        //       'fichefraisencours' => $ficheFraisEnCours,
        //   ));
        //}


        //public function addFraisForfaitTypeAction(Request $request, $id = null)
        //{
        //    if($id == null){
        //        $fraisForfaitType = new FraisForfaitType();
        //   }else{
        //        $fraisForfaitType = $this->getDoctrine()->getRepository('TestBundle:FraisForfaitType')->find($id);
        //    }

        //   $form = $this->createForm('TestBundle\Form\FraisForfaitTypeType', $fraisForfaitType);
        //    if($id == null){
        //      $form->add('Ajouter', SubmitType::class, array(
        //           'attr'  => array('class' => 'btn','center-align')
        //        ));
        //    }else{
        //       $form->add('Modifier', SubmitType::class, array(
        //           'attr'  => array('class' => 'btn','center-align')
        //        ));
        //   }
        //   $form->handleRequest($request);

        //   $fraisForfaits = $this->getDoctrine()->getRepository('FrontBundle:FraisForfaitType')->findAll();

        //   if ($form->isSubmitted() && $form->isValid()){
        //       $em = $this->getDoctrine()->getManager();
        //       $em->persist($fraisForfaitType);
        //       $em->flush();
        //      $this->addFlash("success", "Frais forfait type ajouté avec succès");
        //      return $this->redirectToRoute('addfraistype');

        //  }

        //return this->$this->redirectToRoute('test_homepage'); //redirection vers la route du choix
        //  return $this->render("@Front/Admin/addFraisType.html.twig",
        //      array('form'=>$form->createView(),
        //          'fraisforfaits' => $fraisForfaits,
        //      ));
        //}

        //public function removeFraisForfaitTypeAction(Request $request, $id)
        //{

        //   $fraisForfaitType = $this->getDoctrine()->getRepository('TestBundle:FraisForfaitType')->find($id);

        //   if ($fraisForfaitType != null) {
        //       $em = $this->getDoctrine()->getManager();
        //       $em->remove($fraisForfaitType);
        //       $em->flush();
        //      $this->addFlash("success", "Frais type supprimé avec succès");
        //  }
        //   return $this->redirectToRoute('addfraistype');




}
