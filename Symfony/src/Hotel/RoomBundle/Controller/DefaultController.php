<?php

namespace Hotel\RoomBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('HotelRoomBundle:Default:index.html.twig', array('name' => $name));
    }
}
