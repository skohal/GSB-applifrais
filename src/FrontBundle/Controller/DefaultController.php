<?php

namespace FrontBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FrontBundle\Entity\FicheFrais;

class DefaultController extends Controller
{

    /*Action qui permet d'affiche la page d'accueil on fonction du role */

    public function homePageAction(Request $request)
    {
        $user = $this->getUser();

        //Vérification de l'état des fiches
        $moisEnCours = (new \DateTime())->format('m');
        $anneeEnCours = (new \DateTime())->format('Y');
        $jourEnCours = (new \DateTime())->format('d');
        $etatCloture = $this->getDoctrine()->getRepository('FrontBundle:Etat')->find(2);

        $fichesFrais = $this->getDoctrine()->getRepository('FrontBundle:FicheFrais')->findAll();
        foreach ($fichesFrais as $uneFiche){
            if ($uneFiche->getMois() <= $moisEnCours &&  $jourEnCours>10 && $uneFiche->getEtat()->getId()==1) {
                $uneFiche->setEtat($etatCloture);

                $fraisForfaits = $uneFiche->getFraisForfaits();
                $fraisHorsForfaits = $uneFiche->getFraisHorsForfait();

                //Modifie les frais pour qu'eux aussi soient cloturés
                foreach ($fraisForfaits as $fraisForfait){
                    $fraisForfait->setEtat($etatCloture);
                }
                foreach ($fraisHorsForfaits as $fraisHorsForfait){
                    $fraisHorsForfait->setEtat($etatCloture);
                }
                //Envoie les modifs en bdd
                $em = $this->getDoctrine()->getManager();
                $em->persist($uneFiche);
                $em->flush();
            }
        }

        //Renvoie la homepage correspondante au role de l'user
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY') || $securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $roles = $user->getRoles();

            foreach ($roles as $role) {
                if ($role == "ROLE_ADMIN") {
                    return $this->render('@Front/Admin/homeadmin.html.twig',
                        array('user'=> $user,
                            'roles' => $roles
                        ));
                } else if($role == 'ROLE_COMPTABLE') {
                    return $this->render('@Front/Comptable/homepageComptable.html.twig',
                        array('user'=> $user,
                            'roles' => $roles
                        ));
                } else{
                    return $this->render('@Front/Utilisateur/homeutilisateur.html.twig',
                        array('user'=> $user,
                            'roles' => $roles
                        ));

                }
            }
        } else {
            return $this->render('@Front/Default/Index.html.twig');
        }
    }


    /*Action  useless*/

    public function validerFicheAction(Request $request, $id)
    {
        $fichefrais = $this->getDoctrine()->getRepository('FrontBundle:FicheFrais')->find($id);
        $fichefrais->setEtat();
        $em = $this->getDoctrine()->getManager();
        $em->persist($fichefrais);
        $em->flush();

        return $this->redirectToRoute('');
    }

    /*Action permet l'acces du site map */

    public function siteMapAction(){
        $user = $this->getUser();
        $roles = $user->getRoles();

        return $this->render("",
            array ('user' => $user,
                'roles' => $roles
            ));
    }


    public function siteplanAction(){

        return $this->render('FrontBundle:Default:siteplan.html.twig');

    }

}