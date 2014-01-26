<?php

namespace Hotel\BillBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('HotelBillBundle:Default:index.html.twig', array('name' => $name));
    }
}
