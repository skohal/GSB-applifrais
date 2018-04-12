<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use FrontBundle\Entity\user;

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
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('addutilisateur');

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


}
