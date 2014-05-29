<?php

namespace Hotel\RoomBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Hotel\RoomBundle\Entity\PhoneCall;
use Hotel\RoomBundle\Form\PhoneCallType;

/**
 * PhoneCall controller.
 *
 */
class PhoneCallController extends Controller
{

    /**
     * Lists all PhoneCall entities.
     *
     */
    public function indexAction(){

        $session = $this->getRequest()->getSession();

        if($session->has('user') && $session->get('user')->getRole() == 'admin'){

            $em = $this->getDoctrine()->getManager();

            $entities = $em->getRepository('HotelRoomBundle:PhoneCall')->findAll();

            $options['user'] = $session->get('user');
            $options['entities'] = $entities;

            return $this->render('HotelRoomBundle:PhoneCall:index.html.twig', $options);
        }
        return $this->render('HotelMainBundle:Main:accessdenied.html.twig');
    }
    /**
     * Creates a new PhoneCall entity.
     *
     */
    public function newAction(Request $request){

        $session = $this->getRequest()->getSession();

        if($session->has('user') && $session->get('user')->getRole() == 'admin'){

            $user = $session->get('user');

            $entity = new PhoneCall();
            $form = $this->createNewForm($entity);
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('phonecall_show', array('id' => $entity->getId())));
            }

            return $this->render('HotelRoomBundle:PhoneCall:new.html.twig', array(
                'entity' => $entity,
                'form'   => $form->createView(),
                'user'   => $user,
            ));
        }
        return $this->render('HotelMainBundle:Main:accessdenied.html.twig');
    }

    /**
    * Creates a form to create a PhoneCall entity.
    *
    * @param PhoneCall $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createNewForm(PhoneCall $entity){

        $form = $this->createForm(new PhoneCallType(), $entity, array(
            'action' => $this->generateUrl('phonecall_new'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Enviar'));

        return $form;
    }

    /**
     * Finds and displays a PhoneCall entity.
     *
     */
    public function showAction($id){

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HotelRoomBundle:PhoneCall')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Llamada no encontrada.');
        }

        $session = $this->getRequest()->getSession();

        if($session->has('user') && $session->get('user')->getRole() == 'admin'){

            $options['entity'] = $entity;
            $options['user'] = $session->get('user');

            return $this->render('HotelRoomBundle:PhoneCall:show.html.twig', $options);
        }
        return $this->render('HotelMainBundle:Main:accessdenied.html.twig');
    }
}
