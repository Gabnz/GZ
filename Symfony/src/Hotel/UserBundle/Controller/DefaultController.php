<?php

namespace Hotel\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('HotelUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
