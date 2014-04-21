<?php

namespace Hotel\RoomBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * Lists all Reserve entities (admin only).
     *
     */
     public function indexAction(){
        
        $session = $this->getRequest()->getSession();

        if($session->has('user') && $session->get('user')->getRole() == 'admin'){

            $em = $this->getDoctrine()->getManager();
            $qb = $em->createQueryBuilder();

            $reservations = $qb->select('r')
            ->from('HotelRoomBundle:Reserve', 'r')
            ->addOrderBy('r.roomtype', 'DESC')
            ->addOrderBy('r.roomcategory', 'ASC')
            ->getQuery()
            ->getResult();

            $user = $session->get('user');

            return $this->render('HotelRoomBundle:Reserve:index.html.twig', array(
                'entities' => $reservations,
                'prefix' => 'user',
                'user' => $user,
            ));
        }
        /*si no es admin, no puede ver la lista de reservas*/
        throw $this->createNotFoundException('No eres administrador, pagina no disponible.');
    }

    public function dummyAction(Request $request, $category = null){/*

        $session = $this->getRequest()->getSession();

        $entity = new Reserve();
        $form = $this->createReserveForm($entity);
        $form->handleRequest($request);
        $entity->setRoomcategory($category);

        if ($form->isValid()){

            $availableCount = $em->getRepository('HotelRoomBundle:Reserve')
                ->availableCount($entity->getRoomtype(), $entity->getRoomcategory(),
                    $entity->getEntrydate(), $entity->getExitdate());

            $availableAction = $form->get('available')->isClicked()
                ? true
                : false;

            //si solo se desea verificar la disponibilidad
            if($availableAction){

                return new Response('<html><body>Hello '.$availableCount.'!</body></html>');

            }else{
                //si hay disponibilidad, reserva.
                if($availableCount > 0){

                    $em->persist($entity);
                    $em->flush();
                    return $this->redirect($this->generateUrl('reserve_show', array('id' => $entity->getId())));

                }else{
                    //pagina de error
                    throw $this->createNotFoundException('No hay habitaciones disponibles para la reserva.');
                }
            }
        }

        if(!$session->has('user')){

            return $this->render('HotelRoomBundle:Reserve:reserve.html.twig', array(
                'entity' => $entity,
                'form'   => $form->createView(),
                'prefix' => 'guest',
                'user' => null,
                'category' => $category,
            ));
        }else{

            $user = $session->get('user');
            $entity->setUser($user);

            $form->add('submit', 'submit', array('label' => 'Reservar'));
                
            return $this->render('HotelRoomBundle:Reserve:reserve.html.twig', array(
                'entity' => $entity,
                'form'   => $form->createView(),
                'prefix' => 'user',
                'user' => $user,
                'category' => $category,
            ));
        }*/
        return new Response('<html><body>Pagina en proceso :/</body></html>');
    }

    public function reserve2Action(Request $request, $category = null){

        $session = $this->getRequest()->getSession();

        $entity = new Reserve();
        $form = $this->createReserveForm($entity);
        $form->handleRequest($request);
        $entity->setRoomcategory($category);

         if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush(); 

                return $this->redirect($this->generateUrl('reserve_user'));   
            }

            if(!$session->has('user')){

               // $entity->setUser($user);
                return $this->render('HotelRoomBundle:Reserve:reserve.html.twig', array(
                    'entity' => $entity,
                    'form'   => $form->createView(),
                    'prefix' => 'guest',
                    'user' => null,
                    'category' => $category,
                ));
            }else{

                $user = $session->get('user');
                $entity->setUser($user);

                return $this->render('HotelRoomBundle:Reserve:reserve.html.twig', array(
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

    /**
     * Creates a new Reserve entity (for now, only for admins).
     *
     */
    public function reserveAction(Request $request){

        $session = $this->getRequest()->getSession();

        /*si es admin, puede crear reservas de esta forma*/
        if($session->has('user') && $session->get('user')->getRole() == 'admin'){

            $entity = new Reserve();
            $form = $this->createReserveForm($entity);

            $user = $session->get('user');
            $em = $this->getDoctrine()->getManager();

            $selected = $em->getRepository('HotelUserBundle:User')->findOneBy(
                array('id' => $form['userlist']->getData())
            );

            $entity->setUser($selected);
            $form->handleRequest($request);

            if($form->isValid()) {

                $availableCount = $em->getRepository('HotelRoomBundle:Reserve')
                    ->availableCount($entity->getRoomtype(), $entity->getRoomcategory(),
                        $entity->getEntrydate(), $entity->getExitdate());

                $availableAction = $form->get('available')->isClicked()
                    ? true
                    : false;

                /*si solo se desea verificar la disponibilidad*/
                if($availableAction){

                    return new Response('<html><body>Hello '.$availableCount.'!</body></html>');

                }else{
                    /*si hay disponibilidad, reserva.*/
                    if($availableCount > 0){

                        $em->persist($entity);
                        $em->flush();
                        return $this->redirect($this->generateUrl('reserve_show', array('id' => $entity->getId())));

                    }else{
                        /*pagina de error*/
                        throw $this->createNotFoundException('No hay habitaciones disponibles para la reserva.');
                    }
                }
            }

            return $this->render('HotelRoomBundle:Reserve:new.html.twig', array(
                'entity' => $entity,
                'form'   => $form->createView(),
                'user' => $user,
            ));
        }
        /*si no es admin, no puede crear reservas de esta forma*/
        throw $this->createNotFoundException('No eres administrador, pagina no disponible.');
    }

    /**
    * Creates a form to create a Reserve entity (only for admins).
    *
    * @param Reserve $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createReserveForm(Reserve $entity){

        $form = $this->createForm(new ReserveType(), $entity, array(
            'action' => $this->generateUrl('reserve_admin_new'),
            'method' => 'POST',
        ));

        $session = $this->getRequest()->getSession();
        $user = $session->get('user');

        $em = $this->getDoctrine()->getManager();
        $userlist = $em->getRepository('HotelUserBundle:User')->findAll();

        $list;

        foreach ($userlist as $u) {
            $list[$u->getId()] =  $u->getId() ." - ". $u->getFirstname() ." ". $u->getLastname();
        }

        $form->add('userlist', 'choice', array('choices' => $list, 'label' => 'usuario', 'mapped' => false, 'data' => $user->getId()))
             ->add('submit', 'submit', array('label' => 'Reservar'))
             ->add('available', 'submit', array('label' => 'Disponibilidad'));

        return $form;
    }

    /**
     * Displays a form to create a new Reserve entity.
     *
     */
    /*public function newAction()
    {
        $entity = new Reserve();
        $form   = $this->createReserveForm($entity);

        return $this->render('HotelRoomBundle:Reserve:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }*/

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

        $form->add('submit', 'submit', array('label' => 'Update'))
        ->add('restatus','choice',array('choices' => array('active' => 'Activa', 'occupied' => 'Ocupada', 'canceled' => 'Cancelada', 'complete' => 'Completa'),
            'label'=>'Estado'))
        ;

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
