<?php

namespace FrontBundle\Controller;

use FrontBundle\Entity\user;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class userController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('FrontBundle:user')->findAll();

        return $this->render('FrontBundle::user/index.html.twig', array(
            'users' => $users,
        ));
    }


    public function showAction(user $user)
    {

        return $this->render('FrontBundle::user:show.html.twig', array(
            'user' => $user,
        ));
    }
}
