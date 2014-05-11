<?php

namespace Hotel\RoomBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Hotel\RoomBundle\Entity\Room;
use Hotel\RoomBundle\Form\RoomType;

/**
 * Room controller.
 *
 */
class RoomController extends Controller
{

    /*
     * Lists all Room entities.
     *
    */
    public function indexAction(){

        $session = $this->getRequest()->getSession();

        /*si es admin, puede ver la lista de usuarios registrados*/
        if($session->has('user') && $session->get('user')->getRole() == 'admin'){

            $user = $session->get('user');
            
            $em = $this->getDoctrine()->getManager();
            $qb = $em->createQueryBuilder();

            $rooms = $qb->select('r')
            ->from('HotelRoomBundle:Room', 'r')
            ->addOrderBy('r.roomtype', 'DESC')
            ->addOrderBy('r.roomcategory', 'ASC')
            ->getQuery()
            ->getResult();
            /*muestra una lista de los usuarios registrados*/
            return $this->render('HotelRoomBundle:Room:index.html.twig', array(
                'entities' => $rooms, 'user' => $user));
        }
        /*si no es admin, no puede ver la lista de habitaciones*/
        throw $this->createNotFoundException('No eres administrador, pagina no disponible.');
    }

    /**
     * Finds and displays a Room entity.
     *
     */
    public function showAction($id){

        $session = $this->getRequest()->getSession();
        /*si es un admin, muestra los datos de la habitacion*/
        if($session->has('user') && $session->get('user')->getRole() == 'admin'){

            $em = $this->getDoctrine()->getManager();

           $entity = $em->getRepository('HotelRoomBundle:Room')->find($id);

            if(!$entity)
                throw $this->createNotFoundException('Habitacion no encontrada.');

            $user = $session->get('user');

            return $this->render('HotelRoomBundle:Room:show.html.twig', array(
                'entity'      => $entity,
                'user' => $user,
            ));
        }
        /*si no es un admin, no muestra los datos de la habitacion*/
        throw $this->createNotFoundException('No eres administrador, pagina no disponible.');
    }
}
