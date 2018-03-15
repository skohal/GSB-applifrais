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
        return $this->render('FrontBundle:Admin:homeadmin.html.twig');
    }

    public function addfraistypeAction()
    {
        return $this->render('FrontBundle:Admin:addfraistype.html.twig');
    }


    public function addUtilisateurAction(Request $request)
    {
        $user = new user();
        $user->setDateCreation(new \DateTime());
        $form = $this->createForm('FrontBundle\Form\userType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Utilisateur ajouté');
        } else {
            $this->addFlash('notice', 'Erreur: uitilisateur non ajouté');
        }

        return $this->render('FrontBundle:Admin:addutilisateur.html.twig', array('form' => $form->createView()));


    }

    public function gererfichesfraisAction()
    {
        return $this->render('FrontBundle:Admin:Gererfichesfrais.html.twig');
    }

    public function listeutilisateurAction()
    {
        return $this->render('FrontBundle:Admin:listeutilisateur.html.twig');
    }

    public function voirfichefraisAction()
    {
        return $this->render('FrontBundle:Admin:voirfichefrais.html.twig');
    }

    public function listeuserAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('FrontBundle:user')->findAll();

        return $this->render('FrontBundle::Admin/listeutilisateur.html.twig', array(
            'users' => $users,
        ));
    }

    public function modifieruserAction(request $request, $id)
    {
        $referer = $request->headers->get('referer');

        $user = $this->getDoctrine()->getRepository('FrontBundle:user')->find($id);
        $form = $this->createForm('FrontBundle\Form\userType', $user);
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
