<?php

namespace Hotel\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Hotel\UserBundle\Entity\User;
use Hotel\UserBundle\Form\UserType;
use Hotel\UserBundle\Entity\Login;
use Hotel\UserBundle\Form\LoginType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * User controller.
 *
 */
class UserController extends Controller
{
    /**
     * Lists all User entities.
     * Only available for admins.
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
            $entities = $em->getRepository('HotelUserBundle:User')->findAll();
            /*muestra una lista de los usuarios registrados*/
            return $this->render('HotelUserBundle:User:index.html.twig', array(
                'entities' => $entities, 'user' => $user));
        }
        /*si es invitado, no puede ver la lista de usuarios registrados*/
        throw $this->createNotFoundException('No estas registrado, pagina no disponible.');
    }
    /**
     * Creates a new User entity.
     * Only available for admins and guests.
     */
    public function newAction(Request $request){

        $session = $this->getRequest()->getSession();
        /*si es un invitado o un admin, prosigue con el registro*/
        if(!$session->has('user') || ($session->has('user') && $session->get('user')->getRole() == 'admin')){

            $entity = new User();
            $form = $this->createNewForm($entity);
            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                /*en este punto, si no tiene un usuario entonces es un invitado*/
                if(!$session->has('user')){
                    /*guarda la sesion y redirecciona a pagina de bienvenida*/
                    $session->set('user', $entity);
                    return $this->redirect($this->generateUrl('main_welcome'));
                }else{
                    /*en caso de que sea un admin, muestra los datos del usuario registrado*/
                    return $this->redirect($this->generateUrl('user_edit', array('id' => $entity->getId())));
                }
            }

            if(!$session->has('user')){

                $options['prefix'] = 'guest';
            }else{

                $options['prefix'] = 'user';
                $options['user'] = $session->get('user');
            }

            $options['form'] = $form->createView();

            return $this->render('HotelUserBundle:User:new.html.twig', $options);
        }
        /*en caso de que sea un usuario estandar el que quiera registrar, deniega la accion*/
        throw $this->createNotFoundException('No eres administrador ni invitado, pagina no disponible.');
    }

    /**
    * Creates a form to create a User entity.
    *
    * @param User $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createNewForm(User $entity){

        $session = $this->getRequest()->getSession();

        $form = $this->createForm(new UserType('new'), $entity, array(
            'action' => $this->generateUrl('user_new'),
            'method' => 'POST',
        ));

        if($session->has('user') && $session->get('user')->getRole() == 'admin')
            $form->add('role', 'choice', array( 'choices' => array('standard' => 'Estandar', 'admin' => 'Administrador'),'label' => 'Tipo de usuario'));

        $form->add('submit', 'submit', array('label' => 'Enviar'));

        return $form;
    }

    /**
    * Creates a form to edit a User entity.
    *
    * @param User $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(User $entity, $type = 'edit'){

        $session = $this->getRequest()->getSession();

        if($type == 'edit'){

            $options['action'] = $this->generateUrl('user_edit', array('id' => $entity->getId()));
        }else{

            $options['action'] = $this->generateUrl('user_edit_pass', array('id' => $entity->getId()));
        }

        $options['method'] = 'PUT';

        $form = $this->createForm(new UserType($type), $entity, $options);

        if($type == 'edit' && $session->has('user') && $session->get('user')->getRole() == 'admin')
            $form->add('role', 'choice', array( 'choices' => array('standard' => 'Estandar', 'admin' => 'Administrador'),'label' => 'Tipo de usuario'));
        
        $form->add('submit', 'submit', array('label' => 'Actualizar'));

        return $form;
    }

    public function editpassAction(Request $request, $id){

        $session = $this->getRequest()->getSession();

        $em = $this->getDoctrine()->getManager();


        if($session->has('user')){

            if($session->get('user')->getRole() == 'admin' || $session->get('user')->getId() == $id){

                $entity = $em->getRepository('HotelUserBundle:User')->find($id);

                $actualPass = $entity->getPass();

                if(!$entity)
                    throw $this->createNotFoundException('Usuario no encontrado.');

                $passForm = $this->createEditForm($entity, 'edit_pass');
                $passForm->handleRequest($request);

                if($passForm->isValid()){

                    if($passForm->get('actualpass')->getData() == $actualPass){

                        $em->flush();

                        return $this->redirect($this->generateUrl('user_edit', array('id' => $id)));

                    }else{

                        $passForm->get('actualpass')->addError(new FormError('Contrasena invalida.'));
                    }
                }

                $user = $session->get('user');

                return $this->render('HotelUserBundle:User:edit.html.twig', array(
                    'entity'      => $entity,
                    'pass_form'   => $passForm->createView(),
                    'user' => $user,
                ));
            }
            /*en caso de que no sea un admin y quiera editar una entidad distinta a la suya, deniega la accion*/
            throw $this->createNotFoundException('Acceso a otro usuario denegado, pagina no disponible.');
        }
        /*en caso de que sea un invitado, deniega la accion*/
        throw $this->createNotFoundException('No estas registrado, pagina no disponible.');
    }
    /**
     * Edits an existing User entity.
     * Only available for admins and the user with the same id.
     */
    public function editAction(Request $request, $id){

        $session = $this->getRequest()->getSession();

        $em = $this->getDoctrine()->getManager();

        /*si es un usuario estandar o un admin, prosigue con la accion*/
        if($session->has('user')){

            if($session->get('user')->getRole() == 'admin' || $session->get('user')->getId() == $id){

                $entity = $em->getRepository('HotelUserBundle:User')->find($id);

                if(!$entity)
                    throw $this->createNotFoundException('Usuario no encontrado.');

                $editForm = $this->createEditForm($entity);
                $editForm->handleRequest($request);

                if ($editForm->isValid()) {

                    $em->flush();

                    /*en caso de que un usuario este editando su propia informacion, la actualiza*/
                    if($session->get('user')->getId() == $id){
                        $session->clear();
                        $session->set('user', $entity);
                    }

                    /*muestra los datos editados*/
                    return $this->redirect($this->generateUrl('user_edit', array('id' => $id)));
                }

                $user = $session->get('user');

                return $this->render('HotelUserBundle:User:edit.html.twig', array(
                    'entity'      => $entity,
                    'edit_form'   => $editForm->createView(),
                    'user' => $user,
                ));
            }
            /*en caso de que no sea un admin y quiera editar una entidad distinta a la suya, deniega la accion*/
            throw $this->createNotFoundException('Acceso a otro usuario denegado, pagina no disponible.');
        }
        /*en caso de que sea un invitado, deniega la accion*/
        throw $this->createNotFoundException('No estas registrado, pagina no disponible.');
    }

    /**
     * Let a user login.
     * Only available for guests.
     * Simplify the code, pending.
     */
    public function loginAction(Request $request){

        $session = $this->getRequest()->getSession();

        if(!$session->has('user')){

            $login = new Login();
            $form = $this->createForm(new LoginType(), $login, array(
                'action' => $this->generateUrl('user_login'),
                'method' => 'POST',
            ));
            $form->add('submit', 'submit', array('label' => 'Entrar'));

            $form->handleRequest($request);

            if($form->isValid()){
                //verifica si el correo esta registrado
                $repository = $this->getDoctrine()
                ->getRepository('HotelUserBundle:User');

                $user = $repository->findOneBy(array('email' => $login->getEmail(), 'pass' => $login->getPass()));

                if(!$user){

                    $form->get('email')->addError(new FormError('Correo o contrasena invalida.'));

                }else{
                    //inicia sesion con los datos del usuario que hizo login
                    $session = $this->getRequest()->getSession();
                    $session->set('user', $user);
                    /*redirecciona a la pagina de bienvenida*/
                    return $this->redirect($this->generateUrl('main_welcome'));
                }
            }

            return $this->render('HotelUserBundle:User:login.html.twig',
                array('form' => $form->createView()));
        }
        /*si el usuario ya ingreso, deniega la accion*/
        throw $this->createNotFoundException('Ya ingresaste, pagina no disponible.');
    }

    /**
     * Let a user logout.
     * Only available for logged in users.
     */
    public function logoutAction(){

        $session = $this->getRequest()->getSession();
        /*si es un usuario el que desea cerrar sesion, se prosigue con la accion*/
        if($session->has('user')){
            $session->clear();
            return $this->redirect($this->generateUrl('user_login'));
        }
        /*si es un invitado, se deniega la accion*/
        throw $this->createNotFoundException('No has ingresado para salirte, pagina no disponible.');
    }
}
