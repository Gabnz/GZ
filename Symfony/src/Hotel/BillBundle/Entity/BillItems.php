<?php

namespace Hotel\BillBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BillItems
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class BillItems
{

    /**
    * @ORM\ManyToOne(targetEntity="Bill", inversedBy="billitems")
    * @ORM\JoinColumn(name="bill_id", referencedColumnName="id", nullable=FALSE)
    */
    private $bill;

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
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var integer
     *
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount;

    /**
     * @var integer
     *
     * @ORM\Column(name="room_id", type="integer")
     */
    private $roomId;


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
     * Set name
     *
     * @param string $name
     * @return BillItems
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return BillItems
     */
    public function setPrice($price)
    {
        $this->price = $price;
    
        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set amount
     *
     * @param integer $amount
     * @return BillItems
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    
        return $this;
    }

    /**
     * Get amount
     *
     * @return integer 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set roomId
     *
     * @param integer $roomId
     * @return BillItems
     */
    public function setRoomId($roomId)
    {
        $this->roomId = $roomId;
    
        return $this;
    }

    /**
     * Get roomId
     *
     * @return integer 
     */
    public function getRoomId()
    {
        return $this->roomId;
    }

    /**
     * Set bill
     *
     * @param \Hotel\BillBundle\Entity\Bill $bill
     * @return BillItems
     */
    public function setBill(\Hotel\BillBundle\Entity\Bill $bill)
    {
        $this->bill = $bill;
    
        return $this;
    }

    /**
     * Get bill
     *
     * @return \Hotel\BillBundle\Entity\Bill 
     */
    public function getBill()
    {
        return $this->bill;
    }
}