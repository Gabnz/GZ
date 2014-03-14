<?php

namespace Hotel\RoomBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Hotel\RoomBundle\Entity\Reserve;
use Hotel\RoomBundle\Form\ReserveType;

/**
 * Reserve controller.
 *
 */
class ReserveController extends Controller
{

    /**
     * Lists all Reserve entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('HotelRoomBundle:Reserve')->findAll();

        return $this->render('HotelRoomBundle:Reserve:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Reserve entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Reserve();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('reserve_show', array('id' => $entity->getId())));
        }

        return $this->render('HotelRoomBundle:Reserve:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Reserve entity.
    *
    * @param Reserve $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Reserve $entity)
    {
        $form = $this->createForm(new ReserveType(), $entity, array(
            'action' => $this->generateUrl('reserve_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Reserve entity.
     *
     */
    public function newAction()
    {
        $entity = new Reserve();
        $form   = $this->createCreateForm($entity);

        return $this->render('HotelRoomBundle:Reserve:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Reserve entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HotelRoomBundle:Reserve')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Reserve entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HotelRoomBundle:Reserve:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Reserve entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HotelRoomBundle:Reserve')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Reserve entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HotelRoomBundle:Reserve:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Reserve entity.
    *
    * @param Reserve $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Reserve $entity)
    {
        $form = $this->createForm(new ReserveType(), $entity, array(
            'action' => $this->generateUrl('reserve_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Reserve entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HotelRoomBundle:Reserve')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Reserve entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('reserve_edit', array('id' => $id)));
        }

        return $this->render('HotelRoomBundle:Reserve:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Reserve entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('HotelRoomBundle:Reserve')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Reserve entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('reserve'));
    }

    /**
     * Creates a form to delete a Reserve entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reserve_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
