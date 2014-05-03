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
            ->addOrderBy('r.roomtype', 'ASC')
            ->addOrderBy('r.roomcategory', 'ASC')
            ->addOrderBy('r.entrydate', 'ASC')
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

    public function reserveAction(){

        $session = $this->getRequest()->getSession();

        if(!$session->has('user')){

            $options['prefix'] = 'guest';
        }else{

            $options['prefix'] = 'user';
            $options['user'] = $session->get('user');
        }
                
        return $this->render('HotelRoomBundle:Reserve:new-reserve.html.twig', $options);
    }

    public function newAction(Request $request, $category){

        $session = $this->getRequest()->getSession();

        $entity = new Reserve();
        $form = $this->createNewForm($entity);
        $entity->setRoomcategory($category);

        $options['entity'] = $entity;
        $options['category'] = $category;

        if($session->has('user')){

            $user = $session->get('user');
            //$em = $this->getDoctrine()->getManager();
            //$selected = $em->getRepository('HotelUserBundle:User')->find($user->getId());
            $entity->setUser($user);
            $options['prefix'] = 'user';
            $options['user'] = $user;
        }else{

            $form->remove('submit');
            $options['prefix'] = 'guest';
        }

        $form->handleRequest($request);

        if($form->isValid()){

            return new Response('<html><body>Formulario correcto.</body></html>');

        }

        $options['form'] = $form->createView();
        
        return $this->render('HotelRoomBundle:Reserve:new-form.html.twig', $options);
    }

    public function reserve2Action(Request $request){

        $session = $this->getRequest()->getSession();
        
        $entity = new Reserve();
        $form = $this->createNewForm($entity);
        $form->handleRequest($request);
        //$entity->setRoomcategory($category);
        
        if ($form->isValid()){
            /*

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
            }*/
        }

        if(!$session->has('user')){
            $form->remove('submit');

            return $this->render('HotelRoomBundle:Reserve:reserve.html.twig', array(
                //'entity' => $entity,
                //'form'   => $form->createView(),
                'prefix' => 'guest',
                //'user' => null,
                //'category' => $category,
            ));
        }else{

            $user = $session->get('user');
            //$entity->setUser($user);

            //$form->add('submit', 'submit', array('label' => 'Reservar'));
                
            return $this->render('HotelRoomBundle:Reserve:reserve.html.twig', array(
                //'entity' => $entity,
                //'form'   => $form->createView(),
                'prefix' => 'user',
                'user' => $user,
                //'category' => $category,
            ));
        }
        //return new Response('<html><body>Pagina en proceso :/</body></html>');
    }

    /**
    * Creates a form to create a Reserve entity (only for admins).
    *
    * @param Reserve $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createNewForm(Reserve $entity, $formtype = 'new'){

        $form = $this->createForm(new ReserveType($formtype), $entity, array(
            'action' => $this->generateUrl('reserve_'.$formtype),
            'method' => 'POST',
        ));

        $session = $this->getRequest()->getSession();
        $user = $session->get('user');

        $em = $this->getDoctrine()->getManager();

        $form->add('submit', 'submit', array('label' => 'Reservar'))
        ;

        return $form;
    }

    /**
     * Creates a new Reserve entity (for now, only for admins).
     *
     */
    public function newAdminAction(Request $request){

        $session = $this->getRequest()->getSession();

        /*si es admin, puede crear reservas de esta forma*/
        if($session->has('user') && $session->get('user')->getRole() == 'admin'){

            $entity = new Reserve();

            $form = $this->createNewForm($entity, 'new_admin');

            $user = $session->get('user');
            $em = $this->getDoctrine()->getManager();

            $selected = $em->getRepository('HotelUserBundle:User')->findOneBy(
                array('id' => $form['user']->getData())
            );

            $entity->setUser($selected);
            $form->handleRequest($request);

            if($form->isValid()) {

                $available = $em->getRepository('HotelRoomBundle:Reserve')
                    ->availableCount($entity->getRoomtype(), $entity->getRoomcategory(),
                        $entity->getEntrydate(), $entity->getExitdate());

                $availableAction = $form->get('available')->isClicked()
                    ? true
                    : false;

                /*si solo se desea verificar la disponibilidad*/
                if($availableAction){

                    return $this->render('HotelRoomBundle:Reserve:new.html.twig', array(
                        'entity' => $entity,
                        'form'   => $form->createView(),
                        'user' => $user,
                        'availableCount' => $available['count'],
                    ));

                }else{
                    /*si hay disponibilidad, reserva.*/
                    if($available['count'] > 0){

                        /*en caso de que sea un caso especial, se toma en cuenta*/
                        if($available['special'] == true){
                            $entity->setRoomtype('double');
                            $entity->setSpecial(true);
                        }

                        $em->persist($entity);
                        $em->flush();
                        return $this->redirect($this->generateUrl('reserve_show', array('id' => $entity->getId())));

                    }else{
                        /*si no hay disponibilidad, lo notifica.*/
                        return $this->render('HotelRoomBundle:Reserve:new.html.twig', array(
                        'entity' => $entity,
                        'form'   => $form->createView(),
                        'user' => $user,
                        'reserved' => false,
                    ));
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
     * Finds and displays a Reserve entity.
     *
     */
    public function showAction($id){

        $session = $this->getRequest()->getSession();

        /*si es admin, puede ver la reserva de esta forma*/
        if($session->has('user') && $session->get('user')->getRole() == 'admin'){

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HotelRoomBundle:Reserve')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Pagina no encontrada.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HotelRoomBundle:Reserve:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'user' => $session->get('user')));
        }
        /*si no es admin, no puede ver la reserva de esta forma*/
        throw $this->createNotFoundException('No eres administrador, pagina no disponible.');
    }

    /**
    * Creates a form to edit a Reserve entity.
    *
    * @param Reserve $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Reserve $entity){

        $form = $this->createForm(new ReserveType('edit'), $entity, array(
            'action' => $this->generateUrl('reserve_edit', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar'))
        ->add('user', 'text', array('label' => 'Usuario', 'mapped' => false, 'data' => $entity->getUser()->getEmail(), 'attr' => array('readonly' => true)));

        return $form;
    }
    /**
     * Edits an existing Reserve entity.
     *
     */
    public function editAction(Request $request, $id){

        $session = $this->getRequest()->getSession();

        /*si es admin, puede editar la reserva de esta forma*/
        if($session->has('user') && $session->get('user')->getRole() == 'admin'){

            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('HotelRoomBundle:Reserve')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Pagina no encontrada.');
            }

            $actualRestatus = $entity->getRestatus();

            $editForm = $this->createEditForm($entity);
            $editForm->handleRequest($request);

            if($editForm->isValid()){

                $update = $em->getRepository('HotelRoomBundle:Reserve')
                    ->updateReserve($actualRestatus, $editForm['restatus']->getData(), $id);

                if($update['status'] == true){
                    /*si la reserva se actualizo correctamente, la muestra*/
                    return $this->redirect($this->generateUrl('reserve_show', array('id' => $entity->getId())));
                }

                /*si no se pudo hacer la actualizacion de la reservacion, se muestra un mensaje*/
                $entity->setRestatus($actualRestatus);
                
                return $this->render('HotelRoomBundle:Reserve:edit.html.twig', array(
                    'entity'      => $entity,
                    'edit_form'   => $editForm->createView(),
                    'user' => $session->get('user'),
                    'message' => $update['message'],
                ));
            }

            return $this->render('HotelRoomBundle:Reserve:edit.html.twig', array(
                'entity'      => $entity,
                'edit_form'   => $editForm->createView(),
                'user' => $session->get('user'),
            ));
        }
        /*si no es admin, no puede ver la reserva de esta forma*/
        throw $this->createNotFoundException('No eres administrador, pagina no disponible.');
    }
    /**
     * Deletes a Reserve entity.
     *
     */
    public function deleteAction(Request $request, $id){

        $session = $this->getRequest()->getSession();

        if($session->has('user') && $session->get('user')->getRole() == 'admin'){

            $form = $this->createDeleteForm($id);
            $form->handleRequest($request);

            if($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $entity = $em->getRepository('HotelRoomBundle:Reserve')->find($id);

                if (!$entity) {
                    throw $this->createNotFoundException('Reserva no encontrada.');
                }

                if($entity->getRestatus() == 'occupied'){
                    throw $this->createNotFoundException('No se puede eliminar una reserva ocupada.');
                }

                $em->remove($entity);
                $em->flush();
            }
            return $this->redirect($this->generateUrl('reserve_admin'));
        }
        /*si no es admin, no puede ver la reserva de esta forma*/
        throw $this->createNotFoundException('No eres administrador, pagina no disponible.');
    }

    /**
     * Creates a form to delete a Reserve entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id){

        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reserve_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Eliminar', 'attr' => array('class' => 'alert button')))
            ->getForm()
        ;
    }
}
