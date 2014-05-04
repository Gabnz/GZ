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
     public function indexAction($_route){
        
        $session = $this->getRequest()->getSession();

        if($session->has('user')){

            $options['prefix'] = 'user';
            $user = $session->get('user');
            $options['user'] = $user;
            $options['route'] = $_route;

            if($_route == 'reserve_admin'){

                if($session->get('user')->getRole() == 'admin'){

                    $em = $this->getDoctrine()->getManager();
                    $qb = $em->createQueryBuilder();

                    $reservations = $qb->select('r')
                    ->from('HotelRoomBundle:Reserve', 'r')
                    ->addOrderBy('r.roomtype', 'ASC')
                    ->addOrderBy('r.roomcategory', 'ASC')
                    ->addOrderBy('r.entrydate', 'ASC')
                    ->getQuery()
                    ->getResult();

                    $options['entities'] = $reservations;
                }else{
                    /*si no es admin, no puede ver la lista de reservas*/
                    throw $this->createNotFoundException('No eres administrador, pagina no disponible.');
                }

                return $this->render('HotelRoomBundle:Reserve:index.html.twig', $options);
            }else{

                $reservations = $this->getDoctrine()->getRepository('HotelRoomBundle:Reserve')
                ->findByUser($user);

                $options['entities'] = $reservations;

                return $this->render('HotelRoomBundle:Reserve:user-index.html.twig', $options);
            }
        }
        /*si no es admin, no puede ver la lista de reservas*/
        throw $this->createNotFoundException('No estas registrado, pagina no disponible.');
    }

    public function reserveAction(){

        $session = $this->getRequest()->getSession();

        if(!$session->has('user')){

            $options['prefix'] = 'guest';
        }else{

            $options['prefix'] = 'user';
            $options['user'] = $session->get('user');
        }

        return $this->render('HotelRoomBundle:Reserve:reserve.html.twig', $options);
    }

    public function newAction(Request $request, $category){

        $session = $this->getRequest()->getSession();
        $em = $this->getDoctrine()->getManager();

        $entity = new Reserve();
        $form = $this->createNewForm($entity, 'new', $category);
        $entity->setRoomcategory($category);

        $options['category'] = $category;

        if($session->has('user')){

            $user = $session->get('user');
                
            $selected = $em->getRepository('HotelUserBundle:User')->findOneBy(
                array('id' => $user->getId())
            );

            $entity->setUser($selected);
            $options['prefix'] = 'user';                
            $options['user'] = $user;

        }else{

            $options['prefix'] = 'guest';
        }

        $form->handleRequest($request);

        if($form->isValid()){

            $available = $em->getRepository('HotelRoomBundle:Reserve')
                ->availableCount($entity->getRoomtype(), $category,
                    $entity->getEntrydate(), $entity->getExitdate());

            $availableAction = $form->get('available')->isClicked()
                ? true
                : false;

            /*si solo se desea verificar la disponibilidad*/
            if($availableAction){

                $options['availableCount'] = $available['count'];

            }else{
                //si hay disponibilidad, reserva.
                if($available['count'] > 0){

                    //en caso de que sea un caso especial, se toma en cuenta
                    if($available['special'] == true){
                        $entity->setRoomtype('double');
                        $entity->setSpecial(true);
                    }

                    $em->persist($entity);
                    $em->flush();

                    return $this->redirect($this->generateUrl('reserve_edit', array('id' => $entity->getId())));
                }else{
                    //si no hay disponibilidad, lo notifica.
                    $options['reserved'] = false;
                }
            }
        }

        $options['form'] = $form->createView();
        
        return $this->render('HotelRoomBundle:Reserve:new.html.twig', $options);
    }

    /**
    * Creates a form to create a Reserve entity (only for admins).
    *
    * @param Reserve $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createNewForm(Reserve $entity, $formtype, $category = null){

        $session = $this->getRequest()->getSession();

        if($formtype == 'new'){
            $url = $this->generateUrl(
                'reserve_new',
                array('category' => $category));
        }
        else{
            $url = $this->generateUrl(
                'reserve_new_admin');
        }

        $form = $this->createForm(new ReserveType($formtype), $entity, array(
            'action' => $url,
            'method' => 'POST',
        ));

        if(!$session->has('user'))
            $form->remove('submit');
        
        return $form;
    }

    /**
     * Creates a new Reserve entity (for now, only for admins).
     *
     */
    public function newAdminAction(Request $request){

        $session = $this->getRequest()->getSession();
        $em = $this->getDoctrine()->getManager();

        /*si es admin, puede crear reservas de esta forma*/
        if($session->has('user') && $session->get('user')->getRole() == 'admin'){

            $entity = new Reserve();
            $form = $this->createNewForm($entity, 'new_admin');
            $user = $session->get('user');

            $selected = $em->getRepository('HotelUserBundle:User')->findOneBy(
                array('email' => $form['user']->getData())
            );

            $entity->setUser($selected);
            $options['prefix'] = 'user';
            $options['user'] = $user;

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

                    $options['availableCount'] = $available['count'];

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
                        return $this->redirect($this->generateUrl('reserve_edit_admin', array('id' => $entity->getId())));

                    }else{
                        /*si no hay disponibilidad, lo notifica.*/
                        $options['reserved'] = false;
                    }
                }
            }

            $options['form'] = $form->createView();

            return $this->render('HotelRoomBundle:Reserve:new.html.twig', $options);
        }
        /*si no es admin, no puede crear reservas de esta forma*/
        throw $this->createNotFoundException('No eres administrador, pagina no disponible.');
    }

    /**
    * Creates a form to edit a Reserve entity.
    *
    * @param Reserve $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Reserve $entity, $_route){

        if($_route == "reserve_edit")
            $url = $this->generateUrl('reserve_edit', array('id' => $entity->getId()));
        else
            $url = $this->generateUrl('reserve_edit_admin', array('id' => $entity->getId()));

        $form = $this->createForm(new ReserveType('edit'), $entity, array(
            'action' => $url,'method' => 'PUT'));

        if($_route == "reserve_edit"){
            $form
            ->remove('restatus')
            ->add('restatus','choice',array('choices' => array('active' => 'Activa', 'canceled' => 'Cancelada'),
            'label'=>'Estado'));
        }

        $form->add('submit', 'submit', array('label' => 'Actualizar'));
        return $form;
    }
    /**
     * Edits an existing Reserve entity.
     *
     */
    public function editAction(Request $request, $id, $_route){

        $session = $this->getRequest()->getSession();
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('HotelRoomBundle:Reserve')->find($id);

        if(!$entity)
            throw $this->createNotFoundException('Pagina no encontrada.');

        $continue = false;

        /*si es admin, puede editar la reserva de esta forma*/
        if($session->has('user')){

            if($_route == 'reserve_edit_admin' && $session->get('user')->getRole() == 'admin')
                $continue = true;
            elseif($entity->getUser()->getId() == $session->get('user')->getId())
                $continue = true;
            
            if($continue){

                $actualRestatus = $entity->getRestatus();

                $editForm = $this->createEditForm($entity, $_route);
                $editForm->handleRequest($request);

                if($editForm->isValid()){

                    $update = $em->getRepository('HotelRoomBundle:Reserve')
                        ->updateReserve($actualRestatus, $editForm['restatus']->getData(), $id);

                    if($update['status'] == true){

                        if ( ( $actualRestatus =='occupied' && $editForm['restatus']->getData()=='complete' ) 
                             ||
                             ( $actualRestatus == 'active' && $editForm['restatus']->getData()=='canceled' )){
                             
                            return $this->redirect($this->generateUrl('bill_generate', 
                                array( 'user_id' => $entity->getUser()->getId(),
                                       'reser_id' => $id
                                )));                    

                        }

                        /*si la reserva se actualizo correctamente, la muestra*/
                       return $this->redirect($this->generateUrl($_route, array('id' => $entity->getId())));
                    }

                    /*si no se pudo hacer la actualizacion de la reservacion, se muestra un mensaje*/
                    $entity->setRestatus($actualRestatus);
                    
                    return $this->render('HotelRoomBundle:Reserve:edit.html.twig', array(
                        'entity'      => $entity,
                        'edit_form'   => $editForm->createView(),
                        'user' => $session->get('user'),
                        'message' => $update['message'],
                        'route' => $_route,
                    ));
                }

                return $this->render('HotelRoomBundle:Reserve:edit.html.twig', array(
                    'entity'      => $entity,
                    'edit_form'   => $editForm->createView(),
                    'user' => $session->get('user'),
                    'route' => $_route,
                ));
            }
            throw $this->createNotFoundException('No eres administrador, pagina no disponible.');
        }
        /*si no es admin, no puede ver la reserva de esta forma*/
        throw $this->createNotFoundException('No estas registrado, pagina no disponible.');
    }
}