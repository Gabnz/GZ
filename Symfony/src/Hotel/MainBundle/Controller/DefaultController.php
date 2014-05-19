<?php

namespace Hotel\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller{

    public function indexAction(){

    	$options['prefix'] = 'guest';

    	$session = $this->getRequest()->getSession();

        if($session->has('user')){

        	$options['prefix'] = 'user';
        	$options['user'] = $session->get('user');
     	}

     return $this->render('HotelMainBundle:Main:index.html.twig', $options);
    }
}