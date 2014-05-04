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
 * Factura controller.
 *
 */
class BillController extends Controller
{

    // funcion de prueba para probar boton que genere factura
    //public function testAction(){            
      //  return $this->render('HotelBillBundle:Bill:test.html.twig');       
   // }

    /**
     * Lista todas las facturas.
     *
     */
     public function indexAction(){
        
        $session = $this->getRequest()->getSession();

        if($session->has('user')){

            $em = $this->getDoctrine()->getManager();
            $user = $session->get('user');

            if ($user->getRole() == 'admin'){ // si es el admin, son todas las facturas.
                $result = $em->getRepository('HotelBillBundle:Bill')->bills(-1);

            }else{ // si es un usuario, son todas sus facturas.
                $id = $user->getId();
                $result = $em->getRepository('HotelBillBundle:Bill')->bills($id);
            }

            if ($result == NULL) {
             /*si no existen facturas para mostrar */
             throw $this->createNotFoundException('no existen facturas disponible asociados a tu cuenta.  =/');            
                
            }else{

                return $this->render('HotelBillBundle:Bill:index.html.twig', array(
                    'entity_bill' => $result,
                    'user' => $user
                ));
            }
        }
        /*si no es un usuario, no puede ver la lista de reservas*/
        throw $this->createNotFoundException('No eres usuario, pagina no disponible.');
    }


    /**
     * Genera la factura asociada a un usuario.
     *
     */
    public function generateAction($user_id, $reser_id){
      

        $session = $this->getRequest()->getSession();

        /*si eres usuario registrado */
        if($session->has('user')){

            $em = $this->getDoctrine()->getManager();

            $user = $em->getRepository('HotelUserBundle:User')->findOneBy(
            array('email' => $user_id)
            );

            $selected = $em->getRepository('HotelRoomBundle:Reserve')->findBy(
            array('user' => $user)
            );           

            // verifica si el usuario tiene reserva
            if (count($selected) > 0) {

                // actualiza el estatus a 'expire' de todas las facturas
                $aux = $em->getRepository('HotelBillBundle:Bill')->updatebillstatus($user->getId());               

                // consultando el tipo de reserva (completada o cancelada)
                $result = $em->getRepository('HotelBillBundle:Bill')->reser_status($reser_id);      

                // consultando usuario para agregarlo a la factura
                $selected = $em->getRepository('HotelUserBundle:User')->findOneBy(
                   array('id' => $user->getId())
                   );

                if (!$selected) {
                    throw $this->createNotFoundException('Usuario no encontrado.');
                } 

                // creando la factura
                $newbill = new Bill();
                $newbill->setUser($selected);
                $newbill->setTypeBill($result['restatus']);
                $newbill->setBillstatus('actual');
                $date = new \DateTime("today");
                $newbill->setIssuedate($date);
                $em->persist($newbill);
                $em->flush();

                // generando la factura  y sus billitems (minibar, telefono, alojamiento) correspondientes
                $result = $em->getRepository('HotelBillBundle:Bill')->bill_generate($user->getId(), $reser_id); 
 
                // consulta la factura recien creada
                $newbill = $em->getRepository('HotelBillBundle:Bill')->findOneBy(
                array(
                  'billstatus' => 'actual',
                  'user' => $user
                   ));

               
                // lo redireciona a la pagina de mostrar factura (con la que se acaba de crear)
                return $this->redirect($this->generateUrl('bill_show',
                 array(
                    'bill_id' => $newbill->getId(),
                    'user_id' => $user->getId() 
                    )));

            }else

             throw $this->createNotFoundException('No tienes reservas asociadas.');

        }
        /*si es invitado, no puede generar facturas*/
        throw $this->createNotFoundException('No eres usuario registrado, pagina no disponible.');

    }


    /**
     * Genera la version en pdf de una factura.
     *
     */
    public function pdfAction($bill_id, $user_id){

            $session = $this->getRequest()->getSession();

            $em = $this->getDoctrine()->getManager();
            // obtener el usuario
            $entity_user = $em->getRepository('HotelUserBundle:User')->find($user_id); 

            // obtener la factura 
            $entity_bill = $em->getRepository('HotelBillBundle:Bill')->findOneBy(
               array(
                  'id' => $bill_id
                   ));

         // consulta todos los items asociado a la factura actual del usuario
        $selected = $em->getRepository('HotelBillBundle:Bill')->billitems($bill_id);

        // crea la vista
        $html = $this->renderView('HotelBillBundle:Bill:pdf.html.twig', array(
            'entity_user' => $entity_user,
            'entity_bill' => $entity_bill,
            'billitems' => $selected
            ));       

        // retorna la vista en pdf.
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
     * Muestra un factura en parcticular.
     *
     */
    public function showAction($bill_id, $user_id){

        $session = $this->getRequest()->getSession();
      
        if($session->has('user')){

            $em = $this->getDoctrine()->getManager();
            $entity_user = $em->getRepository('HotelUserBundle:User')->find($user_id); 

            if (!$entity_user) {
                throw $this->createNotFoundException('Usuario no encontrado.');
            }            

            $user = $session->get('user');
            /*si no es un usuario registrado, no puede ver la lista de facturas*/
            if($user->getRole() != 'guest'){                

                // obtener la factura recien agregada
                $entity_bill = $em->getRepository('HotelBillBundle:Bill')->findOneBy(
                array(
                  'id' => $bill_id
                   ));

                // consulta todos los items asociado a la factura actual del usuario
                $selected = $em->getRepository('HotelBillBundle:Bill')->billitems($bill_id);

                // renderiza la vista.
                return $this->render('HotelBillBundle:Bill:bill.html.twig', array(
                'entity_user' => $entity_user,
                'entity_bill' => $entity_bill,
                'prefix' => 'user',
                'user' => $user,
                'billitems' => $selected
            ));                     


            }else
             throw $this->createNotFoundException('No eres usuario registrado, pagina no disponible.');

        }
        /*si es invitado, no puede ver las facturas*/
        throw $this->createNotFoundException('No eres usuario registrado, pagina no disponible.');
    }

    /**
     * Creates a new Bill entity.
     *
     */
    /* public function createAction(Request $request)
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
    }*/

    /*
    * Creates a form to create a Bill entity.
    *
    * @param Bill $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    
    private function createCreateForm(Bill $entity)
    {
        $form = $this->createForm(new BillType(), $entity, array(
            'action' => $this->generateUrl('bill_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }*/

    /*
     * Displays a form to create a new Bill entity.
     
     
    public function newAction()
    {
        $entity = new Bill();
        $form   = $this->createCreateForm($entity);

        return $this->render('HotelBillBundle:Bill:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }**/

    /**
     * Finds and displays a Bill entity.
     *
     */
    /*
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
    */

    /*
     * Displays a form to edit an existing Bill entity.
     *
     
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
    }**/

    /*
    * Creates a form to edit a Bill entity.
    *
    * @param Bill $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    
    private function createEditForm(Bill $entity)
    {
        $form = $this->createForm(new BillType(), $entity, array(
            'action' => $this->generateUrl('bill_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }**/
    /*
     * Edits an existing Bill entity.
     *
     *
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
    }**/
    /*
     * Deletes a Bill entity.
     *
     *

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
    }**/

    /*
     * Creates a form to delete a Bill entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     *
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bill_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    **/
}
