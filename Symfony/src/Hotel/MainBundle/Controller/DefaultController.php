<?php

namespace Hotel\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction(){

    	$session = $this->getRequest()->getSession();

        if($session->has('user')){

        	$user = $session->get('user');

        	return $this->render('HotelMainBundle:Main:index.html.twig', array('prefix' => 'user', 'user' => $user));
    	}

    	return $this->render('HotelMainBundle:Main:index.html.twig', array('prefix' => 'guest'));
    }
}
