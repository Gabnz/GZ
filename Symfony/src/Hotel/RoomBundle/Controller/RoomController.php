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

        if($session->has('user')){

            $user = $session->get('user');
            /*si no es admin, no puede ver la lista de usuarios registrados*/
            if($user->getRole() != 'admin')
                throw $this->createNotFoundException('No eres administrador, pagina no disponible.');
            /*en caso de ser admin, prosigue*/
            $em = $this->getDoctrine()->getManager();
            $entities = $em->getRepository('HotelRoomBundle:Room')->findAll();
            /*muestra una lista de los usuarios registrados*/
            return $this->render('HotelRoomBundle:Room:index.html.twig', array(
                'entities' => $entities, 'user' => $user));
        }
        /*si es invitado, no puede ver la lista de usuarios registrados*/
        throw $this->createNotFoundException('No eres administrador, pagina no disponible.');
    }


    /**
     * Creates a new Room entity.
     *
     */
    public function createAction(Request $request)
    {
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
        ));
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
            'action' => $this->generateUrl('room_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }


    /**
     * Displays a form to create a new Room entity.
     *
     */
    public function newAction()
    {
        $entity = new Room();
        $form   = $this->createCreateForm($entity);

        return $this->render('HotelRoomBundle:Room:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }


    /**
     * Finds and displays a Room entity.
     *
     */
    public function showAction($id){

        $session = $this->getRequest()->getSession();
        /*si es un usuario estandar o un admin, prosigue con la accion*/
        if($session->has('user')){

            if($session->get('user')->getRole() == 'admin'){

                $em = $this->getDoctrine()->getManager();

               $entity = $em->getRepository('HotelRoomBundle:Room')->find($id);

                if (!$entity) {
                    throw $this->createNotFoundException('habitacion no encontrada.');
                }

                $deleteForm = $this->createDeleteForm($id);

                $user = $session->get('user');

                return $this->render('HotelRoomBundle:Room:show.html.twig', array(
                    'entity'      => $entity,
                    'delete_form' => $deleteForm->createView(),
                    'user' => $user,
                    ));
            }
            /*en caso de que no sea un admin, deniega la accion*/
            throw $this->createNotFoundException('No eres administrador, pagina no disponible.');

        }
        /*en caso de que sea un invitado, deniega la accion*/
        throw $this->createNotFoundException('No estas registrado, pagina no disponible.');
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
            'action' => $this->generateUrl('room_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));



        $form->add('submit', 'submit', array('label' => 'Actualizar'));

        return $form;
    }


    /**
     * Displays a form to edit an existing Room entity.
     *
     */
    public function editAction(Request $request, $id){

        $session = $this->getRequest()->getSession();
        /*si es un usuario admin, prosigue con la accion*/
        if($session->has('user')){

            if($session->get('user')->getRole() == 'admin'){

                $em = $this->getDoctrine()->getManager();

                $entity = $em->getRepository('HotelRoomBundle:Room')->find($id);

                if (!$entity) {
                    throw $this->createNotFoundException('habitacion no encontrada.');
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
            /*en caso de que no sea un admin, deniega la accion*/
            throw $this->createNotFoundException('ANo eres administrador, pagina no disponible.');
        }
        /*en caso de que sea un invitado, deniega la accion*/
        throw $this->createNotFoundException('No estas registrado, pagina no disponible.');
    }

    
    /**
     * Edits an existing Room entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HotelRoomBundle:Room')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Room entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('room_show', array('id' => $id)));
        }

        return $this->render('HotelRoomBundle:Room:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Room entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('HotelRoomBundle:Room')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Room entity.');
            }

            $em->remove($entity);
            $em->flush();
        } 

        return $this->redirect($this->generateUrl('room'));
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
