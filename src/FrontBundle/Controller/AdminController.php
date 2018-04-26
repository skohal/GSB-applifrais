<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use FrontBundle\Entity\user;
use FrontBundle\Entity\FraisForfaitType;

class AdminController extends Controller
{

    /*Action d'ajoute d'uilisateur */

    public function addUtilisateurAction(Request $request)
    {
        $user = new user();
        $user->setDateCreation(new \DateTime());
        $form = $this->createForm('FrontBundle\Form\userType', $user);
        $form ->add("Ajouter", SubmitType::class, array(
            'attr'  => array('class' => 'btn','center-align')));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Utilisateur ajouté');

            return$this->redirectToRoute("listeutilisateur");
        } else {
            $this->addFlash('notice', 'Erreur: utilisateur non ajouté');
        }

        return $this->render('FrontBundle:Admin:addutilisateur.html.twig', array('form' => $form->createView()));

    }

    /*Action d'affichage de la liste des utiliasteur */

    public function listeuserAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('FrontBundle:user')->findAll();

        return $this->render('FrontBundle::Admin/listeutilisateur.html.twig', array(
            'users' => $users,
        ));
    }

    /*Action de modificatin d'utilisateur */

    public function modifieruserAction(request $request, $id)
    {
        $referer = $request->headers->get('referer');

        $user = $this->getDoctrine()->getRepository('FrontBundle:user')->find($id);
        $form = $this->createForm('FrontBundle\Form\userType', $user);
        $form ->add("Modifier", SubmitType::class, array(
            'attr'  => array('class' => 'btn','center-align')));
        $form->handleRequest($request);

        $user->getId();

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setDateModif(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash("success", "Utilisateur modifié avec succès");

            return $this->redirectToRoute('listeutilisateur');

        }

        return $this->render('@Front/Admin/addutilisateur.html.twig',
            array('form' => $form->createView(),
                "user" => $user,
                "referer" => $referer,
            ));
    }

    /*Action de suppression d'utiliasteur */

    public function supprimeruserAction($id)
    {

        $user = $this->getDoctrine()->getRepository('FrontBundle:user')->find($id);

        if ($user != null) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
            $this->addFlash("success", "Utilisateur supprimé avec succès");
        }
        return $this->redirectToRoute('listeutilisateur');

    }
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

    public function modifierFraisTypeAction(request $request,$id)
    {
        $referer = $request->headers->get('referer');

        $lefraistype = $this->getDoctrine()->getRepository('FrontBundle:FraisForfaitType')->find($id);
        $formfft = $this->createForm('FrontBundle\Form\FraisForfaitTypeType', $lefraistype);
        $formfft ->add("Modifier", SubmitType::class, array(
            'attr'  => array('class' => 'btn','center-align')));
        $formfft->handleRequest($request);

        $lefraistype->getId();

        if ($formfft->isSubmitted() && $formfft->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash("success", "Frais Type modifié avec succès");

            return $this->redirectToRoute('addfraistype');
        }
        return $this->render('@Front/Admin/Modifierfraisforfaittype.html.twig',
            array('formfft' => $formfft->createView(),
                "Fraistype" => $lefraistype,
                "referer" => $referer,
            ));
    }
}
