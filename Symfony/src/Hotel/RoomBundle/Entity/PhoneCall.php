<?php

namespace Hotel\RoomBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Hotel\RoomBundle\Validator\Constraints as PhoneAssert;

/**
 * PhoneCall
 *
 * @ORM\Table()
 * @ORM\Entity
 * @PhoneAssert\ValidTime
 */
class PhoneCall
{

    /**
    * @ORM\ManyToOne(targetEntity="Reserve", inversedBy="phonecalls")
    * @ORM\JoinColumn(name="reserve_id", referencedColumnName="id", nullable=FALSE)
    */
    private $reserve;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="calldate", type="date")
     * @Assert\NotBlank(message="Porfavor introduzca una fecha de llamada.")
     * @Assert\Date(message="Porfavor introduzca una fecha valida.")
     */
    private $calldate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="starttime", type="time")
     * @Assert\NotBlank(message="Porfavor introduzca una hora de inicio.")
     * @Assert\Time(message="Porfavor introduzca una hora valida.")
     */
    private $starttime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endtime", type="time")
     * @Assert\NotBlank(message="Porfavor introduzca una hora de terminacion.")
     * @Assert\Time(message="Porfavor introduzca una hora valida.")
     */
    private $endtime;

    /**
     * @var string
     *
     * @ORM\Column(name="phonenumber", type="string", length=30)
     * @Assert\NotBlank(message="Porfavor introduzca un numero de telefono.")
     * @Assert\Regex(
     *      pattern="/^[0-9]*$/",
     *      match=true,
     *      message="Porfavor introduzca un numero de telefono valido.")
     * @Assert\Length(
     *      min="11",
     *      max="30",
     *      exactMessage="Porfavor introduzca un numero con 16 digitos.")
     */
    private $phonenumber;

    /**
     * @var string
     *
     * @ORM\Column(name="calltype", type="string", length=15)
     * @Assert\NotBlank(message="Porfavor introduzca un tipo de llamada.")
     * @Assert\Choice(choices = {"national", "international"}, message = "Porfavor elija un tipo de llamada valido.")
     */
    private $calltype;


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
     * Set calldate
     *
     * @param \DateTime $calldate
     * @return PhoneCall
     */
    public function setCalldate($calldate)
    {
        $this->calldate = $calldate;
    
        return $this;
    }

    /**
     * Get calldate
     *
     * @return \DateTime 
     */
    public function getCalldate()
    {
        return $this->calldate;
    }

    /**
     * Set starttime
     *
     * @param \DateTime $starttime
     * @return PhoneCall
     */
    public function setStarttime($starttime)
    {
        $this->starttime = $starttime;
    
        return $this;
    }

    /**
     * Get starttime
     *
     * @return \DateTime 
     */
    public function getStarttime()
    {
        return $this->starttime;
    }

    /**
     * Set endtime
     *
     * @param \DateTime $endtime
     * @return PhoneCall
     */
    public function setEndtime($endtime)
    {
        $this->endtime = $endtime;
    
        return $this;
    }

    /**
     * Get endtime
     *
     * @return \DateTime 
     */
    public function getEndtime()
    {
        return $this->endtime;
    }

    /**
     * Set phonenumber
     *
     * @param string $phonenumber
     * @return PhoneCall
     */
    public function setPhonenumber($phonenumber)
    {
        $this->phonenumber = $phonenumber;
    
        return $this;
    }

    /**
     * Get phonenumber
     *
     * @return string 
     */
    public function getPhonenumber()
    {
        return $this->phonenumber;
    }

    /**
     * Set calltype
     *
     * @param string $calltype
     * @return PhoneCall
     */
    public function setCalltype($calltype)
    {
        $this->calltype = $calltype;
    
        return $this;
    }

    /**
     * Get calltype
     *
     * @return string 
     */
    public function getCalltype()
    {
        return $this->calltype;
    }

    /**
     * Set reserve
     *
     * @param \Hotel\RoomBundle\Entity\Reserve $reserve
     * @return PhoneCall
     */
    public function setReserve(\Hotel\RoomBundle\Entity\Reserve $reserve)
    {
        $this->reserve = $reserve;
    
        return $this;
    }

    /**
     * Get reserve
     *
     * @return \Hotel\RoomBundle\Entity\Reserve 
     */
    public function getReserve()
    {
        return $this->reserve;
    }
}