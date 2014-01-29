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
        throw $this->createNotFoundException('No eres administrador, pagina no disponible.');
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
                /*en este punto, si tiene un usuario entonces es un admin*/
                if($session->has('user'))
                /*en caso de ser admin, prosigue a realizar el registro y muestra la informacion del usuario*/
                    return $this->redirect($this->generateUrl('user_show', array('id' => $entity->getId())));

                /*en caso de ser un invitado recien registrado, guarda la sesion y redirecciona a pagina de bienvenida*/
                $session->set('user', $entity);
                return $this->redirect($this->generateUrl('user_hello', array('name' => $entity->getFirstname())));
            }

            if(!$session->has('user')){

                return $this->render('HotelUserBundle:User:new.html.twig', array(
                    'form'   => $form->createView(),
                    'prefix' => 'guest',
                ));
            }else{

                $user = $session->get('user');

                return $this->render('HotelUserBundle:User:new.html.twig', array(
                    'form'   => $form->createView(),
                    'prefix' => 'user',
                    'user' => $user,
                ));
            }
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

        $form = $this->createForm(new UserType(), $entity, array(
            'action' => $this->generateUrl('user_new'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Enviar'))
        ->add('role', 'choice', array( 'choices' => array('standard' => 'Estandar', 'admin' => 'Administrador'),'label' => 'Tipo de usuario'));

        return $form;
    }

    /**
     * Displays a form to create a new User entity.
     *
     */
    /*public function newAction()
    {
        $entity = new User();
        $form   = $this->createCreateForm($entity);

        return $this->render(('HotelUserBundle:User:new.html.twig'), array(
            'entity' => $entity,
           'form'   => $form->createView(),
        ));
    }*/

    /**
     * Finds and displays a User entity.
     * Only available for admins and the user with the same id.
     */
    public function showAction($id){

        $session = $this->getRequest()->getSession();
        /*si es un usuario estandar o un admin, prosigue con la accion*/
        if($session->has('user')){

            if($session->get('user')->getRole() == 'admin' || $session->get('user')->getId() == $id){

                $em = $this->getDoctrine()->getManager();

                $entity = $em->getRepository('HotelUserBundle:User')->find($id);

                if (!$entity) {
                    throw $this->createNotFoundException('Usuario no encontrado.');
                }

                $deleteForm = $this->createDeleteForm($id);

                $user = $session->get('user');

                return $this->render('HotelUserBundle:User:show.html.twig', array(
                    'entity'      => $entity,
                    'delete_form' => $deleteForm->createView(),
                    'user' => $user,
                    ));
            }
            /*en caso de que no sea un admin y quiera consultar una entidad distinta a la suya, deniega la accion*/
            throw $this->createNotFoundException('Acceso a otro usuario denegado, pagina no disponible.');

        }
        /*en caso de que sea un invitado, deniega la accion*/
        throw $this->createNotFoundException('No estas registrado, pagina no disponible.');
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     */
    /*public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HotelUserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HotelUserBundle:User:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }*/

    /**
    * Creates a form to edit a User entity.
    *
    * @param User $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(User $entity){

        $form = $this->createForm(new UserType(), $entity, array(
            'action' => $this->generateUrl('user_edit', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar'))
        ->add('role', 'choice', array( 'choices' => array('standard' => 'Estandar', 'admin' => 'Administrador'),'label' => 'Tipo de usuario'));

        return $form;
    }
    /**
     * Edits an existing User entity.
     * Only available for admins and the user with the same id.
     */
    public function editAction(Request $request, $id){

        $session = $this->getRequest()->getSession();
        /*si es un usuario estandar o un admin, prosigue con la accion*/
        if($session->has('user')){

            if($session->get('user')->getRole() == 'admin' || $session->get('user')->getId() == $id){

                $em = $this->getDoctrine()->getManager();

                $entity = $em->getRepository('HotelUserBundle:User')->find($id);

                if (!$entity) {
                    throw $this->createNotFoundException('Usuario no encontrado.');
                }

                $deleteForm = $this->createDeleteForm($id);
                $editForm = $this->createEditForm($entity);
                $editForm->handleRequest($request);

                if ($editForm->isValid()) {
                    $em->flush();

                    return $this->redirect($this->generateUrl('user_show', array('id' => $id)));
                }

                $user = $session->get('user');

                return $this->render('HotelUserBundle:User:edit.html.twig', array(
                    'entity'      => $entity,
                    'edit_form'   => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
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
     * Deletes a User entity.
     * Only available for admins or the user with the same id.
     */
    public function deleteAction(Request $request, $id){

        $session = $this->getRequest()->getSession();
        /*si es un usuario estandar o un admin, prosigue con la accion*/
        if($session->has('user')){

            if($session->get('user')->getRole() == 'admin' || $session->get('user')->getId() == $id){

                $form = $this->createDeleteForm($id);
                $form->handleRequest($request);

                if ($form->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $entity = $em->getRepository('HotelUserBundle:User')->find($id);

                    if (!$entity) {
                        throw $this->createNotFoundException('Usuario no encontrado.');
                    }

                    $em->remove($entity);
                    $em->flush();
                }
                /*si es admin, regresa a la lista de usuarios*/
                if($session->get('user')->getRole() == 'admin')
                    return $this->redirect($this->generateUrl('user'));
                /*si es un usuario estandar, cierra sesion*/
                return $this->redirect($this->generateUrl('user_logout'));
            }
            /*en caso de que no sea un admin y quiera eliminar una entidad distinta a la suya, deniega la accion*/
            throw $this->createNotFoundException('Acceso a otro usuario denegado, pagina no disponible.');

        }
        /*en caso de que sea un invitado, deniega la accion*/
        throw $this->createNotFoundException('No estas registrado, pagina no disponible.');
    }

    /**
     * Creates a form to delete a User entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id){

        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Eliminar'))
            ->getForm()
        ;
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
                    /*si ingresa un usuario estandar, se redirecciona a la pagina de bienvenida*/
                    if($user->getRole() != 'admin')
                        return $this->redirect($this->generateUrl('user_hello', array('name' => $user->getFirstname())));
                    /*en caso de ser un admin, se redirecciona a la lista de usuarios*/
                    return $this->redirect($this->generateUrl('user'));
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
