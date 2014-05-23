<?php

namespace Hotel\MainBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Hotel\MainBundle\Entity\Contact;
use Hotel\MainBundle\Form\ContactType;

/**
 * Contact controller.
 *
 */
class ContactController extends Controller
{
    /**
     * Lists all Contact entities.
     *
     */
    public function indexAction(){

        $session = $this->getRequest()->getSession();
        $em = $this->getDoctrine()->getManager();

        /*si es admin, puede ver la lista de contactos*/
        if($session->has('user') && $session->get('user')->getRole() == 'admin'){

            $user = $session->get('user');

            $entities = $em->getRepository('HotelMainBundle:Contact')->findAll();

            return $this->render('HotelMainBundle:Contact:index.html.twig', array(
                'entities' => $entities,
                'user' => $user,
            ));
        }
        /*si no es admin, no puede ver la lista de contactos*/
        throw $this->createNotFoundException('No eres administrador, pagina no disponible.');
    }
    /**
     * Creates a new Contact entity.
     *
     */
    public function newAction(Request $request){

        $entity = new Contact();
        $form = $this->createNewForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return new Response('true');
        }

        return $this->render('HotelMainBundle:Contact:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Contact entity.
    *
    * @param Contact $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createNewForm(Contact $entity){
        
        $form = $this->createForm(new ContactType(), $entity, array(
            'action' => $this->generateUrl('contact_new'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Finds and displays a Contact entity.
     *
     */
    public function showAction($id){

        $session = $this->getRequest()->getSession();
        $em = $this->getDoctrine()->getManager();

        /*si es admin, puede ver la lista de contactos*/
        if($session->has('user') && $session->get('user')->getRole() == 'admin'){

            $user = $session->get('user');

            $entity = $em->getRepository('HotelMainBundle:Contact')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('No se puede encontrar la entidad.');
            }

            $deleteForm = $this->createDeleteForm($id);

            return $this->render('HotelMainBundle:Contact:show.html.twig', array(
                'entity'      => $entity,
                'delete_form' => $deleteForm->createView(),
                'user' => $user,
            ));
        }
    }

    /**
     * Deletes a Contact entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('HotelMainBundle:Contact')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Entidad no encontrada.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('contact'));
    }

    /**
     * Creates a form to delete a Contact entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('contact_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Eliminar', 'attr' => array('class' => 'button alert')))
            ->getForm()
        ;
    }
}
