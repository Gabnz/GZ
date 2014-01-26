<?php
namespace GZ\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use GZ\UserBundle\Entity\Login;
use GZ\UserBundle\Form\Type\LoginType;
use GZ\UserBundle\Entity\User;
use GZ\UserBundle\Form\Type\UserType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Session\Session;

class UserController extends Controller{

	public function loginAction(){

		$session = $this->getRequest()->getSession();

		if(!$session->has('user'))
			return $this->render('GZMainBundle:login:login.html.twig', array('prefix' => 'guest'));
	}

	public function loginattemptAction(Request $request){

		$login = new Login();

		$form = $this->createForm(new LoginType(), $login);
        $form->handleRequest($request);

        if($form->isValid()){
	        //verifica si el correo esta registrado
	        $repository = $this->getDoctrine()
    		->getRepository('GZUserBundle:User');

    		$user = $repository->findOneBy(array('email' => $login->getEmail(), 'pass' => $login->getPass()));

    		if(!$user){

    			$form->get('email')->addError(new FormError('Correo o contrasena invalida.'));

    		}else{
    			//inicia sesion con los datos del usuario que hizo login
    			$session = $this->getRequest()->getSession();

    			$session->set('user', $user);

	    		//parte que realiza solo si el controlador es ejecutado por ajax
		        if($request->isXmlHttpRequest())
		       		return new Response($this->generateUrl('index'));
		        else
		        	return $this->redirect($this->generateUrl('index'));
    		}
   		}
        return $this->render('GZMainBundle:login:form.html.twig',
        	array('form' => $form->createView()));
	}

	public function logoutAction(){

		$session = $this->getRequest()->getSession();
		$session->clear();

		return $this->redirect($this->generateUrl('index'));
	}

	public function registerAction(){

		$session = $this->getRequest()->getSession();

		if(!$session->has('user'))
			return $this->render('GZMainBundle:register:register.html.twig', array('prefix' => 'guest'));
	}

	public function registerattemptAction(Request $request){

		$user = new User();

		$form = $this->createForm(new UserType(), $user);

        $form->handleRequest($request);

		if($form->isValid()){
		    // guarda el usuario en la base de datos
		    $em = $this->getDoctrine()->getManager();
    		$em->persist($user);
    		$em->flush();

   			$repository = $this->getDoctrine()
    		->getRepository('GZUserBundle:User');

    		$regiuser = $repository->findOneBy(array('email' => $user->getEmail(), 'pass' => $user->getPass())); 		

    		//inicia sesion con los datos del usuario que hizo login
    		$session = $this->getRequest()->getSession();

    		$session->set('user', $regiuser);
			/*parte que realiza solo si el controlador es ejecutado por ajax*/
	        if($request->isXmlHttpRequest())
	       		return new Response($this->generateUrl('index'));
	        else
	        	return $this->redirect($this->generateUrl('index'));
		}
        return $this->render('GZMainBundle:register:form.html.twig',
        	array('form' => $form->createView()));
	}
}