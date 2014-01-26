<?php

namespace Hotel\RoomBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Room
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Room
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="roomtype", type="string", length=10)
     */
    private $roomtype;

    /**
     * @var string
     *
     * @ORM\Column(name="roomcategory", type="string", length=10)
     */
    private $roomcategory;

    /**
     * @var boolean
     *
     * @ORM\Column(name="tv", type="boolean")
     */
    private $tv;

    /**
     * @var boolean
     *
     * @ORM\Column(name="shower", type="boolean")
     */
    private $shower;

    /**
     * @var boolean
     *
     * @ORM\Column(name="jacuzzi", type="boolean")
     */
    private $jacuzzi;

    /**
     * @var boolean
     *
     * @ORM\Column(name="music", type="boolean")
     */
    private $music;

    /**
     * @var boolean
     *
     * @ORM\Column(name="massage", type="boolean")
     */
    private $massage;

    /**
     * @var string
     *
     * @ORM\Column(name="roomstatus", type="string", length=10)
     */
    private $roomstatus;


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
     * Set tv
     *
     * @param boolean $tv
     * @return Room
     */
    public function setTv($tv)
    {
        $this->tv = $tv;
    
        return $this;
    }

    /**
     * Get tv
     *
     * @return boolean 
     */
    public function getTv()
    {
        return $this->tv;
    }

    /**
     * Set shower
     *
     * @param boolean $shower
     * @return Room
     */
    public function setShower($shower)
    {
        $this->shower = $shower;
    
        return $this;
    }

    /**
     * Get shower
     *
     * @return boolean 
     */
    public function getShower()
    {
        return $this->shower;
    }

    /**
     * Set jacuzzi
     *
     * @param boolean $jacuzzi
     * @return Room
     */
    public function setJacuzzi($jacuzzi)
    {
        $this->jacuzzi = $jacuzzi;
    
        return $this;
    }

    /**
     * Get jacuzzi
     *
     * @return boolean 
     */
    public function getJacuzzi()
    {
        return $this->jacuzzi;
    }

    /**
     * Set music
     *
     * @param boolean $music
     * @return Room
     */
    public function setMusic($music)
    {
        $this->music = $music;
    
        return $this;
    }

    /**
     * Get music
     *
     * @return boolean 
     */
    public function getMusic()
    {
        return $this->music;
    }

    /**
     * Set massage
     *
     * @param boolean $massage
     * @return Room
     */
    public function setMassage($massage)
    {
        $this->massage = $massage;
    
        return $this;
    }

    /**
     * Get massage
     *
     * @return boolean 
     */
    public function getMassage()
    {
        return $this->massage;
    }

   

    /**
     * Set roomtype
     *
     * @param string $roomtype
     * @return Room
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
     * Set roomcategory
     *
     * @param string $roomcategory
     * @return Room
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
     * Set roomstatus
     *
     * @param string $roomstatus
     * @return Room
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
}