<?php

namespace Hotel\RoomBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Validator\ExecutionContextInterface;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Assert\Callback(methods={"isDateValid"})
 */

/**
 * Reserve
 *
 * @ORM\Table()
 * @ORM\Entity
 */

class Reserve
{
    /**
    * @ORM\ManyToOne(targetEntity="\Hotel\UserBundle\Entity\User", inversedBy="reserves")
    * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=FALSE)
    */
    private $user;

    /**
    * @ORM\OneToOne(targetEntity="Room")
    * @ORM\JoinColumn(name="room_id", referencedColumnName="id", nullable=TRUE)
    */
    private $room;

    /**
    * @ORM\OneToMany(targetEntity="PhoneCall", mappedBy="reserve")
    */
    private $phonecalls;

    /**
    * @ORM\OneToMany(targetEntity="Consumable", mappedBy="reserve")
    */
    private $consumables;

    public function __construct()
    {
        $this->phonecalls = new ArrayCollection();

        $this->consumables = new ArrayCollection();

        $this->special = false;

        $this->roomstatus = 'active';
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="childbeds", type="integer")
     * @Assert\NotBlank(message="Porfavor introduzca una cantidad.")
     * @Assert\Range(
     *          min = 0,
     *          max = 3,
     *          minMessage = "Porfavor introduzca una cantidad mayor o igual a cero.",
     *          maxMessage = "Porfavor introduzca una cantidad menor o igual a 3.")
     */
    private $childbeds;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="entrydate", type="date")
     * @Assert\NotBlank(message="Porfavor introduzca una fecha de entrada.")
     * @Assert\Date(message="Porfavor introduzca una fecha valida.")
     */
    private $entrydate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="exitdate", type="date")
     * @Assert\NotBlank(message="Porfavor introduzca una fecha de salida.")
     * @Assert\Date(message="Porfavor introduzca una fecha valida.")
     */
    private $exitdate;

    /**
     * @var string
     *
     * @ORM\Column(name="roomcategory", type="string", length=10)
     * @Assert\NotBlank(message="Porfavor introduzca una categoria.")
     * @Assert\Choice(choices = {"standard", "bussiness", "high"}, message = "Porfavor elija una categoria valida.")
     */
    private $roomcategory;

    /**
     * @var string
     *
     * @ORM\Column(name="roomtype", type="string", length=10)
     * @Assert\NotBlank(message="Porfavor introduzca un tipo.")
     * @Assert\Choice(choices = {"individual", "double"}, message = "Porfavor elija un tipo valido.")
     */
    private $roomtype;

    /**
     * @var string
     *
     * @ORM\Column(name="roomstatus", type="string", length=10)
     * @Assert\NotBlank(message="Porfavor introduzca un status.")
     * @Assert\Choice(choices = {"active", "occupied", "closed", "canceled"}, message = "Porfavor elija un status valido.")
     */
    private $roomstatus;

    /**
     * @var boolean
     *
     * @ORM\Column(name="special", type="boolean")
     */
    private $special;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set childbeds
     *
     * @param integer $childbeds
     * @return Reserve
     */
    public function setChildbeds($childbeds)
    {
        $this->childbeds = $childbeds;
    
        return $this;
    }

    /**
     * Get childbeds
     *
     * @return integer 
     */
    public function getChildbeds()
    {
        return $this->childbeds;
    }

    /**
     * Set entrydate
     *
     * @param \DateTime $entrydate
     * @return Reserve
     */
    public function setEntrydate($entrydate)
    {
        $this->entrydate = $entrydate;
    
        return $this;
    }

    /**
     * Get entrydate
     *
     * @return \DateTime 
     */
    public function getEntrydate()
    {
        return $this->entrydate;
    }

    /**
     * Set exitdate
     *
     * @param \DateTime $exitdate
     * @return Reserve
     */
    public function setExitdate($exitdate)
    {
        $this->exitdate = $exitdate;
    
        return $this;
    }

    /**
     * Get exitdate
     *
     * @return \DateTime 
     */
    public function getExitdate()
    {
        return $this->exitdate;
    }

   

    /**
     * Set special
     *
     * @param boolean $special
     * @return Reserve
     */
    public function setSpecial($special)
    {
        $this->special = $special;
    
        return $this;
    }

    /**
     * Get special
     *
     * @return boolean 
     */
    public function getSpecial()
    {
        return $this->special;
    }

    /**
     * Set user
     *
     * @param \Hotel\UserBundle\Entity\User $user
     * @return Reserve
     */
    public function setUser(\Hotel\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Hotel\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set roomcategory
     *
     * @param string $roomcategory
     * @return Reserve
     */
    public function setRoomcategory($roomcategory)
    {
        $this->roomcategory = $roomcategory;
    
        return $this;
    }

    /**
     * Get roomcategory
     *
     * @return string 
     */
    public function getRoomcategory()
    {
        return $this->roomcategory;
    }

    /**
     * Set roomtype
     *
     * @param string $roomtype
     * @return Reserve
     */
    public function setRoomtype($roomtype)
    {
        $this->roomtype = $roomtype;
    
        return $this;
    }

    /**
     * Get roomtype
     *
     * @return string 
     */
    public function getRoomtype()
    {
        return $this->roomtype;
    }

    /**
     * Set roomstatus
     *
     * @param string $roomstatus
     * @return Reserve
     */
    public function setRoomstatus($roomstatus)
    {
        $this->roomstatus = $roomstatus;
    
        return $this;
    }

    /**
     * Get roomstatus
     *
     * @return string 
     */
    public function getRoomstatus()
    {
        return $this->roomstatus;
    }

    /**
     * Set room
     *
     * @param \Hotel\RoomBundle\Entity\Room $room
     * @return Reserve
     */
    public function setRoom(\Hotel\RoomBundle\Entity\Room $room = null)
    {
        $this->room = $room;
    
        return $this;
    }

    /**
     * Get room
     *
     * @return \Hotel\RoomBundle\Entity\Room 
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * Add phonecalls
     *
     * @param \Hotel\RoomBundle\Entity\PhoneCall $phonecalls
     * @return Reserve
     */
    public function addPhonecall(\Hotel\RoomBundle\Entity\PhoneCall $phonecalls)
    {
        $this->phonecalls[] = $phonecalls;
    
        return $this;
    }

    /**
     * Remove phonecalls
     *
     * @param \Hotel\RoomBundle\Entity\PhoneCall $phonecalls
     */
    public function removePhonecall(\Hotel\RoomBundle\Entity\PhoneCall $phonecalls)
    {
        $this->phonecalls->removeElement($phonecalls);
    }

    /**
     * Get phonecalls
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPhonecalls()
    {
        return $this->phonecalls;
    }

    /**
     * Add consumables
     *
     * @param \Hotel\RoomBundle\Entity\Consumable $consumables
     * @return Reserve
     */
    public function addConsumable(\Hotel\RoomBundle\Entity\Consumable $consumables)
    {
        $this->consumables[] = $consumables;
    
        return $this;
    }

    /**
     * Remove consumables
     *
     * @param \Hotel\RoomBundle\Entity\Consumable $consumables
     */
    public function removeConsumable(\Hotel\RoomBundle\Entity\Consumable $consumables)
    {
        $this->consumables->removeElement($consumables);
    }

    /**
     * Get consumables
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getConsumables()
    {
        return $this->consumables;
    }
    /*validacion de las fechas de entrada y salida, verificando que la de entrada siempre sea la menor.*/
    public function isDateValid(ExecutionContextInterface $context)
    {
        if ($this->entrydate >= $this->exitdate){
            $context->addViolationAt('exitdate', 'La fecha de salida debe ser posterior a la de entrada.', array(), null);
        }
    }
}