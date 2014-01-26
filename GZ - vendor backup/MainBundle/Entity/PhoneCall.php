<?php

namespace GZ\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PhoneCall
 *
 * @ORM\Table()
 * @ORM\Entity
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
     */
    private $calldate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="starttime", type="time")
     */
    private $starttime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endtime", type="time")
     */
    private $endtime;

    /**
     * @var string
     *
     * @ORM\Column(name="phonenumber", type="string", length=30)
     */
    private $phonenumber;

    /**
     * @var string
     *
     * @ORM\Column(name="calltype", type="string", length=15)
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
     * @param \GZ\MainBundle\Entity\Reserve $reserve
     * @return PhoneCall
     */
    public function setReserve(\GZ\MainBundle\Entity\Reserve $reserve)
    {
        $this->reserve = $reserve;
    
        return $this;
    }

    /**
     * Get reserve
     *
     * @return \GZ\MainBundle\Entity\Reserve 
     */
    public function getReserve()
    {
        return $this->reserve;
    }
}