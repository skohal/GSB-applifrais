<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FrontBundle\Entity\user;

class UtilisateurController extends Controller
{

    public function listefraisAction()
    {
        return $this->render('FrontBundle:Utilisateur:listefrais.html.twig');
        
    }




}
