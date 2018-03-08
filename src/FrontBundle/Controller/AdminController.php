<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FrontBundle\Entity\user;

class AdminController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    public function homeadminAction()
    {
        return$this->render('FrontBundle:Admin:homeadmin.html.twig');
    }

    public function addfraistypeAction()
    {
        return$this->render('FrontBundle:Admin:addfraistype.html.twig');
    }


    public function addUtilisateurAction(Request $request)
    {
        $user = new user();
        $user->setDateCreation(new \DateTime());
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
