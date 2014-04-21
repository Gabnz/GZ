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
     * Creates a new Room entity.
     *
     */
    public function newAction(Request $request){

        $session = $this->getRequest()->getSession();

        /*si es admin, puede crear habitaciones*/
        if($session->has('user') && $session->get('user')->getRole() == 'admin'){

            $user = $session->get('user');
            $entity = new Room();
            $form = $this->createCreateForm($entity);
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('room_show', array('id' => $entity->getId())));
            }

            return $this->render('HotelRoomBundle:Room:new.html.twig', array(
                'entity' => $entity,
                'form'   => $form->createView(),
                'user'   => $user,
            ));
        }
        /*si no es admin, no puede crear habitaciones*/
        throw $this->createNotFoundException('No eres administrador, pagina no disponible.');
    }


    /**
    * Creates a form to create a Room entity.
    *
    * @param Room $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Room $entity)
    {
        $form = $this->createForm(new RoomType(), $entity, array(
            'action' => $this->generateUrl('room_new'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
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
            
            $deleteForm = $this->createDeleteForm($id);

            $user = $session->get('user');

            return $this->render('HotelRoomBundle:Room:show.html.twig', array(
                'entity'      => $entity,
                'delete_form' => $deleteForm->createView(),
                'user' => $user,
            ));
        }
        /*si no es un admin, no muestra los datos de la habitacion*/
        throw $this->createNotFoundException('No eres administrador, pagina no disponible.');
    }


    /**
    * Creates a form to edit a Room entity.
    *
    * @param Room $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Room $entity)
    {
        $form = $this->createForm(new RoomType(), $entity, array(
            'action' => $this->generateUrl('room_edit', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar'));

        return $form;
    }


    /**
     * Edits an existing Room entity.
     *
     */
    public function editAction(Request $request, $id){

        $session = $this->getRequest()->getSession();

        /*si es un admin, edita los datos de la habitacion*/
        if($session->has('user') && $session->get('user')->getRole() == 'admin'){

                $em = $this->getDoctrine()->getManager();

                $entity = $em->getRepository('HotelRoomBundle:Room')->find($id);

                if (!$entity) {
                    throw $this->createNotFoundException('Habitacion no encontrada.');
                }

                $deleteForm = $this->createDeleteForm($id);
                $editForm = $this->createEditForm($entity);
                $editForm->handleRequest($request);

                if ($editForm->isValid()) {
                    $em->flush();

                    return $this->redirect($this->generateUrl('room_show', array('id' => $id)));
                }

                $user = $session->get('user');

                return $this->render('HotelRoomBundle:Room:edit.html.twig', array(
                    'entity'      => $entity,
                    'edit_form'   => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
                    'user' => $user,
                ));
        }
        /*si no es un admin, no edita los datos de una habitacion*/
        throw $this->createNotFoundException('No eres administrador, pagina no disponible.');
    }

    /**
     * Deletes a Room entity.
     *
     */
    public function deleteAction(Request $request, $id){

        $session = $this->getRequest()->getSession();

        /*si es un admin, pasa a eliminar la habitacion*/
        if($session->has('user') && $session->get('user')->getRole() == 'admin'){

            $form = $this->createDeleteForm($id);
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $entity = $em->getRepository('HotelRoomBundle:Room')->find($id);

                if(!$entity)
                    throw $this->createNotFoundException('Habitacion no encontrada.');
                

                $em->remove($entity);
                $em->flush();
            } 

            return $this->redirect($this->generateUrl('room'));
        }
        /*si no es un admin, no pasa a eliminar l habitacion*/
        throw $this->createNotFoundException('No eres administrador, pagina no disponible.');
    }

    /**
     * Creates a form to delete a Room entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('room_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Eliminar'))
            ->getForm()
        ;
    }
}
