<?php

namespace Hotel\RoomBundle\Entity;

use Hotel\RoomBundle\Entity\Consumable;

use Doctrine\ORM\EntityRepository;

/**
 * ReserveRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ReserveRepository extends EntityRepository
{
	public function availableCount($roomtype, $roomcategory, $entrydate, $exitdate){

		/*total de habitaciones libres del tipo y categoria de la reserva que se quiere hacer*/
    $em = $this->getEntityManager();
    $freeRooms = $em->getRepository('HotelRoomBundle:Room')->findBy(
        array('roomtype' => $roomtype,
            'roomcategory' => $roomcategory,
            'roomstatus' => 'free')
    );
    
    /*total de reservaciones activas/ocupadas que chocan con la reserva que se quiere hacer*/
    $qb = $em->createQueryBuilder();

    $reserves = $qb->select('r')
       ->from('HotelRoomBundle:Reserve', 'r')
       ->where('r.roomtype = :roomtype')
       ->andWhere('r.roomcategory = :roomcategory')
       ->andWhere($qb->expr()->orX(
        $qb->expr()->between('r.entrydate', ':entrydate', ':exitdate'),
        $qb->expr()->between('r.exitdate', ':entrydate', ':exitdate')))
       ->andWhere($qb->expr()->orX(
        $qb->expr()->eq('r.restatus', ':active'),
        $qb->expr()->eq('r.restatus', ':occupied')))
       ->setParameter('roomtype', $roomtype)
       ->setParameter('roomcategory', $roomcategory)
       ->setParameter('entrydate', $entrydate)
       ->setParameter('exitdate', $exitdate)
       ->setParameter('active', 'active')
       ->setParameter('occupied', 'occupied')
       ->getQuery()
       ->getResult();

    $result = array();

    $result['count'] = count($freeRooms) - count($reserves);
    $result['special'] = false;

    /*si no hay reservaciones disponibles del tipo individual, se busca del tipo doble
    y se toma en cuenta (caso especial)*/
    
    if($result['count'] <= 0 && $roomtype == "individual"){

        $freeRooms = $em->getRepository('HotelRoomBundle:Room')->findBy(
            array('roomtype' => 'double',
                'roomcategory' => $roomcategory,
                'roomstatus' => 'free')
        );

        $qb = $em->createQueryBuilder();

        $reserves = $qb->select('r')
           ->from('HotelRoomBundle:Reserve', 'r')
           ->where('r.roomtype = :roomtype')
           ->andWhere('r.roomcategory = :roomcategory')
           ->andWhere($qb->expr()->orX(
            $qb->expr()->between('r.entrydate', ':entrydate', ':exitdate'),
            $qb->expr()->between('r.exitdate', ':entrydate', ':exitdate')))
           ->andWhere($qb->expr()->orX(
            $qb->expr()->eq('r.restatus', ':active'),
            $qb->expr()->eq('r.restatus', ':occupied')))
           ->setParameter('roomtype', 'double')
           ->setParameter('roomcategory', $roomcategory)
           ->setParameter('entrydate', $entrydate)
           ->setParameter('exitdate', $exitdate)
           ->setParameter('active', 'active')
           ->setParameter('occupied', 'occupied')
           ->getQuery()
           ->getResult();

        $result['count'] = count($freeRooms) - count($reserves);

        if($result['count'] > 0)
          $result['special'] = true;
    }
    /*en caso de que no hayan habitaciones libres la resta con las reservaciones daria negativo*/
    if($result['count'] < 0)
      $result['count'] = 0;

    return $result;
	}

  public function updateReserve($actualRestatus, $newRestatus, $id){

    $em = $this->getEntityManager();
    $reserve = $em->getRepository('HotelRoomBundle:Reserve')->find($id);

    $roomtype = $reserve->getRoomtype();
    $roomcategory = $reserve->getRoomcategory();
    $date = new \DateTime("today");

    $update['status'] = true;
    $update['message'] = null;

    if($newRestatus != $actualRestatus){

      switch($actualRestatus){

          case 'active':
            /*de activa a completa no se pude*/
            if($newRestatus == 'complete'){
                $update['status'] = false;
                $update['message'] = 'Se debe ocupar la habitacion antes de completar la reservacion.';
            }

            if($newRestatus == 'occupied' && ($date < $reserve->getEntrydate() || $date > $reserve->getExitdate())){
              $update['status'] = false;
              $update['message'] = 'No puede se puede ocupar la habitacion antes o despues de las fechas de reserva.';
            }

            break;

          case 'occupied':
            if($newRestatus == 'active'){
                $update['status'] = false;
                $update['message'] = 'La reserva no se puede activar de nuevo.';
            }

            if($newRestatus == 'canceled'){
                $update['status'] = false;
                $update['message'] = 'No se puede cancelar una reserva ocupada.';
            }
            break;

          case 'canceled':
            /*si el estado actual es cancelada, no se puede cambiar*/
            if($newRestatus == 'active'){
                $update['status'] = false;
                $update['message'] = 'No se puede activar una reserva cancelada.';
            }
            if($newRestatus == 'occupied'){
                $update['status'] = false;
                $update['message'] = 'No se puede ocupar una reserva cancelada.';
            }
            if($newRestatus == 'complete'){
                $update['status'] = false;
                $update['message'] = 'No se puede completar una reserva cancelada.';
            }
            break;

          case 'complete':
            /*si el estado actual es completa, no se puede cambiar*/
            if($newRestatus == 'active'){
                $update['status'] = false;
                $update['message'] = 'No se puede activar una reserva completa.';
            }
            if($newRestatus == 'occupied'){
                $update['status'] = false;
                $update['message'] = 'No se puede ocupar una reserva completa.';
            }
            if($newRestatus == 'canceled'){
                $update['status'] = false;
                $update['message'] = 'No se puede cancelar una reserva completa.';
            }
            break;
        }
    }

    if($update['status'] == true){
      
      if($newRestatus == 'occupied'){
        /*si la reserva se va a ocupar, se asigna una habitacion*/
        $selectedRoom = $em->getRepository('HotelRoomBundle:Room')->findOneBy(
          array('roomtype' => $roomtype,
            'roomcategory' => $roomcategory,
            'roomstatus' => 'free')
        );

        $reserve->setRoom($selectedRoom);

        $selectedRoom->setRoomstatus('occupied');
      }elseif($newRestatus == 'complete'){
        /*si la reserva se va a completar, se libera la habitacion que tiene asignada*/

        $selectedRoom = $reserve->getRoom();

        $selectedRoom = $em->getRepository('HotelRoomBundle:Room')->find($selectedRoom->getId());

        $selectedRoom->setRoomstatus('free');

        //$reserve->setRoom(null);
      }
      /*se persisten los datos en la BD*/
      $em->flush();
    }
    return $update;
  }

  public function makeReserve($entity){

    $em = $this->getEntityManager();

    $roomcategory = $entity->getRoomcategory();

    $beer = $em->getRepository('HotelRoomBundle:ConsumableStore')->findOneBy(
    array('name' => 'cerveza', 'roomcategory' => $roomcategory));

    $consumable = new Consumable();
    $consumable->setReserve($entity);
    $consumable->setConsumablestore($beer);
    $consumable->setAmount(4);
    $em->persist($consumable);
    $result['beer'] = $consumable;

    $wine = $em->getRepository('HotelRoomBundle:ConsumableStore')->findOneBy(
    array('name' => 'vino', 'roomcategory' => $roomcategory));

    $consumable = new Consumable();
    $consumable->setReserve($entity);
    $consumable->setConsumablestore($wine);
    $consumable->setAmount(2);
    $em->persist($consumable);
    $result['wine'] = $consumable;

    $water = $em->getRepository('HotelRoomBundle:ConsumableStore')->findOneBy(
    array('name' => 'agua'));

    $consumable = new Consumable();
    $consumable->setReserve($entity);
    $consumable->setConsumablestore($water);
    $consumable->setAmount(4);
    $em->persist($consumable);
    $result['water'] = $consumable;

    $coke = $em->getRepository('HotelRoomBundle:ConsumableStore')->findOneBy(
    array('name' => 'refresco'));

    $consumable = new Consumable();
    $consumable->setReserve($entity);
    $consumable->setConsumablestore($coke);
    $consumable->setAmount(4);
    $em->persist($consumable);
    $result['coke'] = $consumable;

    $alcohol = $em->getRepository('HotelRoomBundle:ConsumableStore')->findOneBy(
    array('name' => 'alcohol', 'roomcategory' => $roomcategory));

    $consumable = new Consumable();
    $consumable->setReserve($entity);
    $consumable->setConsumablestore($alcohol);
    $consumable->setAmount(4);
    $em->persist($consumable);
    $result['alcohol'] = $consumable;

    $entity->addConsumable($result['beer']);
    $entity->addConsumable($result['wine']);
    $entity->addConsumable($result['water']);
    $entity->addConsumable($result['coke']);
    $entity->addConsumable($result['alcohol']);
    $em->persist($entity);

    $em->flush();

    return $result;
  }
}
