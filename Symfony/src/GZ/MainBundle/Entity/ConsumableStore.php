<?php

namespace GZ\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * ConsumableStore
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ConsumableStore
{

    /**
    * @ORM\OneToMany(targetEntity="Consumable", mappedBy="consumablestore")
    */
    private $consumables;

    public function __construct()
    {
        $this->consumables = new ArrayCollection();
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
     * @var string
     *
     * @ORM\Column(name="roomcategory", type="string", length=10)
     */
    private $roomcategory;

    /**
     * @var integer
     *
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="brand", type="string", length=200, nullable=TRUE)
     */
    private $brand;


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
     * @return ConsumableStore
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
     * @return ConsumableStore
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
     * Set roomcategory
     *
     * @param string $roomcategory
     * @return ConsumableStore
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
     * Set amount
     *
     * @param integer $amount
     * @return ConsumableStore
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
     * Set brand
     *
     * @param string $brand
     * @return ConsumableStore
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;
    
        return $this;
    }

    /**
     * Get brand
     *
     * @return string 
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Add consumables
     *
     * @param \GZ\MainBundle\Entity\Consumable $consumables
     * @return ConsumableStore
     */
    public function addConsumable(\GZ\MainBundle\Entity\Consumable $consumables)
    {
        $this->consumables[] = $consumables;
    
        return $this;
    }

    /**
     * Remove consumables
     *
     * @param \GZ\MainBundle\Entity\Consumable $consumables
     */
    public function removeConsumable(\GZ\MainBundle\Entity\Consumable $consumables)
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
}