<?php

namespace GZ\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;

use GZ\MainBundle\Entity\User;

use GZ\MainBundle\Form\Type\UserType;

use GZ\MainBundle\Entity\Login;

use GZ\MainBundle\Form\Type\LoginType;

use GZ\MainBundle\Entity\Reserve;

use GZ\MainBundle\Form\Type\ReserveType;

use GZ\MainBundle\Entity\Contact;

use GZ\MainBundle\Form\Type\ContactType;

use Symfony\Component\Form\FormError;

use Symfony\Component\HttpFoundation\Session\Session;


class MainController extends Controller{
	
	public function contentAction($_route){

		$session = $this->getRequest()->getSession();

		if(!$session->has('user'))
			return $this->render('GZMainBundle:Guest:'.$_route.'.html.twig');
		else
			return $this->render('GZMainBundle:User:'.$_route.'.html.twig', array('user' => $session->get('user')));
	}

	public function loginAction(Request $request){

		$login = new Login();

		$form = $this->createForm(new LoginType(), $login);

        $form->handleRequest($request);

        if($form->isValid()){

	        //verifica si el correo esta registrado
	        $repository = $this->getDoctrine()
    		->getRepository('GZMainBundle:User');

    		$user = $repository->findOneBy(array('email' => $login->getEmail(), 'pass' => $login->getPass()));

    		if(!$user){

    			$form->get('email')->addError(new FormError('Correo o contrasena invalida.'));

    		}else{

    			//inicia sesion con los datos del usuario que hizo login
    			$session = $this->getRequest()->getSession();

    			$session->set('user', $user);

	    		/*parte que realiza solo si el controlador es ejecutado por ajax*/
		        if($request->isXmlHttpRequest())
		       		return new Response($this->generateUrl('index'));
		        else
		        	return $this->redirect($this->generateUrl('index'));
    		}
   		}

        return $this->render('GZMainBundle:Login:form.html.twig',
        	array('form' => $form->createView()));
	}

	public function logoutAction(){

		$session = $this->getRequest()->getSession();

		$session->clear();

		return $this->redirect($this->generateUrl('index'));
	}

	public function registerAction(Request $request){

		$user = new User();

		$form = $this->createForm(new UserType(), $user);

        $form->handleRequest($request);

		if($form->isValid()){
		 
		    // guarda el usuario en la base de datos

		    $em = $this->getDoctrine()->getManager();
    		$em->persist($user);
    		$em->flush();

   			$repository = $this->getDoctrine()
    		->getRepository('GZMainBundle:User');

    		$regiuser = $repository->findOneBy(array('email' => $user->getEmail(), 'pass' => $user->getPass())); 		

    		//inicia sesion con los datos del usuario que hizo login
    		$session = $this->getRequest()->getSession();

    		$session->set('user', $regiuser);
			/*parte que realiza solo si el controlador es ejecutado por ajax*/
	        if($request->isXmlHttpRequest()){

	       		return new Response($this->generateUrl('index'));
	        }
	        else
	        	return $this->redirect($this->generateUrl('index'));
		}

        return $this->render('GZMainBundle:Register:form.html.twig',
        	array('form' => $form->createView()));
	}

	public function availableAction(Request $request){

	}

	public function reserveAction(Request $request, $category = null){

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
		    	return $this->redirect($this->generateUrl('main'));
		}
		return $this->render('GZMainBundle:Reservations:form.html.twig',
        	array('form' => $form->createView(), 'user' => $user, 'category' => $category));
	}


public function contactAction(Request $request){

		$contact = new Contact();	

		$form = $this->createForm(new contactType(), $contact);

        $form->handleRequest($request);

        /*parte que realiza solo si el controlador es ejecutado por ajax*/
        if($request->isXmlHttpRequest()){

       		if($form->isValid()){

       		 	return new Response('success');
       		}
        }

        return $this->render('GZMainBundle::contactform.html.twig',
        	array('form' => $form->createView()));
	}

	public function footerAction(){
	
		return $this->render('GZMainBundle::footer.html.twig');
	}
}
