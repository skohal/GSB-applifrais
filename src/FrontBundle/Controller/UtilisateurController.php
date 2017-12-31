<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FrontBundle\Entity\user;

class UtilisateurController extends Controller
{

    public function homeutilisateurAction()
    {
        return $this->render('FrontBundle:Utilisateur:homeutilisateur.html.twig');

    }


    public function addfraisAction()
    {
        return $this->render('FrontBundle:Utilisateur:addfrais.html.twig');

    }


    public function listefraisAction()
    {
        return $this->render('FrontBundle:Utilisateur:listefrais.html.twig');

    }


    public function modifierfraisAction()
    {
        return $this->render('FrontBundle:Utilisateur:modifierfrais.html.twig');

    }

    public function homeadminAction()
    {
        return$this->render('FrontBundle:Admin:homeadmin.html.twig');
    }

    public function addfraistypeAction()
    {
        return$this->render('FrontBundle:Admin:addfraistype.html.twig');
    }


    public function addutilisateurAction(Request $request)
    {
        $user = new user();
        $form = $this->createForm('FrontBundle\Form\userType',$user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('success','Utilisateur ajouté');
        }else{
            $this->addFlash('notice','Erreur: uitilisateur non ajouté');
        }

        return $this->render('FrontBundle:Admin:addutilisateur.html.twig', array ('form' => $form ->createView()));


    }

        //public function addutilisateurAction()
        // {
        //    return$this->render('FrontBundle:Admin:addutilisateur.html.twig');
        // }

    public function gererfichesfraisAction()
    {
        return$this->render('FrontBundle:Admin:Gererfichesfrais.html.twig');
    }

    public function listeutilisateurAction()
    {
        return$this->render('FrontBundle:Admin:listeutilisateur.html.twig');
    }

    public function voirfichefraisAction()
    {
        return$this->render('FrontBundle:Admin:voirfichefrais.html.twig');
    }
}
