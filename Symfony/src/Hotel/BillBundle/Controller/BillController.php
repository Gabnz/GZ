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

    /**
     * Lista todas las facturas.
     *
     */
     public function indexAction($_route){
        
        $session = $this->getRequest()->getSession();

        if($session->has('user')){

            $em = $this->getDoctrine()->getManager();
            $user = $session->get('user');

            if($_route == 'bill_admin'){

                if ($user->getRole() == 'admin'){ // si es el admin, son todas las facturas.
                    $result = $em->getRepository('HotelBillBundle:Bill')->bills(-1);

                }else{
                    /*si no es admin, no puede ver la lista de reservas*/
                    return $this->render('HotelMainBundle:Main:accessdenied.html.twig');
                }
            }else{ // si es un usuario, son todas sus facturas.

                $id = $user->getId();
                $result = $em->getRepository('HotelBillBundle:Bill')->bills($id);
            }

                return $this->render('HotelBillBundle:Bill:index.html.twig', array(
                    'entity_bill' => $result,
                    'user' => $user
                ));
                
        }
        /*si no es un usuario, no puede ver la lista de reservas*/
        return $this->render('HotelMainBundle:Main:accessdenied.html.twig');
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
            array('id' => $user_id)
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

                if (!$selected) 
                    throw $this->createNotFoundException('Usuario no encontrado.');

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
        return $this->render('HotelMainBundle:Main:accessdenied.html.twig');

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

            if (!$entity_user)
                throw $this->createNotFoundException('Usuario no encontrado.');
                        
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
                return $this->render('HotelMainBundle:Main:accessdenied.html.twig');

        }
        /*si es invitado, no puede ver las facturas*/
        return $this->render('HotelMainBundle:Main:accessdenied.html.twig');
    }

}
