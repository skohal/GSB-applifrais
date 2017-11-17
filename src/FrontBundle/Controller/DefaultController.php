<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{


    public function homepageAction()
    {
        return $this->render('FrontBundle:Default:homepage.html.twig');
    }
}
