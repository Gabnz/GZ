<?php

namespace Hotel\BillBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Session\Session;

use Hotel\BillBundle\Entity\Bill;
use Hotel\BillBundle\Form\BillType;


/**
 * Bill controller.
 *
 */
class BillController extends Controller
{

    public function pdfAction(){

        $this->get('knp_snappy.pdf')->generate('http://www.google.fr', '/Symfony/file.pdf');
    }


    public function pdf2Action(){



        $html = $this->renderView('HotelBillBundle:Bill:pdf.html.twig');
    

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="file.pdf"'
            )
        );
    }    

    /**
     * Lists all Bill entities.
     *
     */


    public function indexAction(){

        $session = $this->getRequest()->getSession();

        if($session->has('user')){

            $user = $session->get('user');
            /*si no es un usuario registrado, no puede ver la lista de facturas*/
            if($user->getRole() != 'guest'){

                return $this->render('HotelBillBundle:Bill:bill.html.twig', array(
                'prefix' => 'user',
                'user' => $user));  


            }else
             throw $this->createNotFoundException('No eres usuario registrado, pagina no disponible.');

        }
        /*si es invitado, no puede ver las facturas*/
        throw $this->createNotFoundException('No eres usuario registrado, pagina no disponible.');
    }


    /*
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('HotelBillBundle:Bill')->findAll();

        return $this->render('HotelBillBundle:Bill:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    */
    /**
     * Creates a new Bill entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Bill();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('bill_show', array('id' => $entity->getId())));
        }

        return $this->render('HotelBillBundle:Bill:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Bill entity.
    *
    * @param Bill $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Bill $entity)
    {
        $form = $this->createForm(new BillType(), $entity, array(
            'action' => $this->generateUrl('bill_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Bill entity.
     *
     */
    public function newAction()
    {
        $entity = new Bill();
        $form   = $this->createCreateForm($entity);

        return $this->render('HotelBillBundle:Bill:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Bill entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HotelBillBundle:Bill')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Bill entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HotelBillBundle:Bill:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Bill entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HotelBillBundle:Bill')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Bill entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HotelBillBundle:Bill:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Bill entity.
    *
    * @param Bill $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Bill $entity)
    {
        $form = $this->createForm(new BillType(), $entity, array(
            'action' => $this->generateUrl('bill_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Bill entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HotelBillBundle:Bill')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Bill entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('bill_edit', array('id' => $id)));
        }

        return $this->render('HotelBillBundle:Bill:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Bill entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('HotelBillBundle:Bill')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Bill entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('bill'));
    }

    /**
     * Creates a form to delete a Bill entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bill_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
