<?php

namespace Hotel\RoomBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Hotel\RoomBundle\Entity\Reserve;
use Hotel\RoomBundle\Form\ReserveType;

use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Session\Session;

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
        
        $session = $this->getRequest()->getSession();

        //$em = $this->getDoctrine()->getManager();
        //$entities = $em->getRepository('HotelRoomBundle:Reserve')->findAll();

            if(!$session->has('user')){

                return $this->render('HotelRoomBundle:Reserve:reserve.html.twig', array(
                   // 'entities'   => $entities,
                    'prefix' => 'guest',
                ));
            }else{

                $user = $session->get('user');

                return $this->render('HotelRoomBundle:Reserve:reserve.html.twig', array(
                   // 'entities'   => $entities,
                    'prefix' => 'user',
                    'user' => $user,
                ));
            }

    }   


    public function reserveAction(Request $request, $category = null){



        $session = $this->getRequest()->getSession();

        $entity = new Reserve();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $entity->setRoomcategory($category);


         if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush(); 

                return $this->redirect($this->generateUrl('reserve'));   
            }       

            if(!$session->has('user')){

               // $entity->setUser($user);
                return $this->render('HotelRoomBundle:Reserve:form.html.twig', array(
                    'entity' => $entity,
                    'form'   => $form->createView(),
                    'prefix' => 'guest',
                    'user' => null,
                    'category' => $category,
                ));
            }else{

                $user = $session->get('user');
                $entity->setUser($user);

                return $this->render('HotelRoomBundle:Reserve:form.html.twig', array(
                    'entity' => $entity,
                    'form'   => $form->createView(),
                    'prefix' => 'user',
                    'user' => $user,
                    'category' => $category,
                ));
            }      

            // los return que si funciona 
            //return $this->render('HotelRoomBundle:Reserve:index.html.twig', 
            //array('prefix' => 'user', 'user' => $user , 'entities' => $entities));

            //return $this->render('HotelRoomBundle:Reserve:index.html.twig', 
            //  array('prefix' => 'guest' , 'entities' => $entities));

                
    




       /*
        $session = $this->getRequest()->getSession();

        $reserve = new Reserve();

        if($session->has('user')){

            $user = $session->get('user');

            $reserve->setUser($user);
        }
        else
            $user = null;

        $reserve->setRoomcategory($category);

        $form = $this->createForm(new ReserveType(), $reserve);

        $form->handleRequest($request);

        if($form->isValid()){


            $Entry = $reserve->getEntrydate();
            $Exit = $reserve->getExitdate();

            alert("paso por aqui");

            echo $Entry;
            echo $Exit;
         
            // buscar el usuario en la base de datos
            if($request->isXmlHttpRequest()){

                return new Response('success');
            }
            else
                return $this->redirect($this->generateUrl('reserve'));
        }
        return $this->render('HotelRoomBundle:reserve:form.html.twig',
            array('form' => $form->createView(), 'user' => $user, 'category' => $category));
            **/
    }

    /* index que muestra el header y la top bar correctamente
     public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $session = $this->getRequest()->getSession();

        $entities = $em->getRepository('HotelRoomBundle:Reserve')->findAll();

            if(!$session->has('user')){

                return $this->render('HotelRoomBundle:Reserve:index.html.twig', array(
                    'entities'   => $entities,
                    'prefix' => 'guest',
                ));
            }else{

                $user = $session->get('user');

                return $this->render('HotelRoomBundle:Reserve:index.html.twig', array(
                    'entities'   => $entities,
                    'prefix' => 'user',
                    'user' => $user,
                ));
            }

    }   
    **/

    /* la que trae por defecto
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('HotelRoomBundle:Reserve')->findAll();

        return $this->render('HotelRoomBundle:Reserve:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    **/
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

        //$form->add('submit', 'submit', array('label' => 'Create'));

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
