<?php

namespace GZ\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Consumable
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Consumable
{

    /**
    * @ORM\ManyToOne(targetEntity="Reserve", inversedBy="consumables")
    * @ORM\JoinColumn(name="reserve_id", referencedColumnName="id", nullable=FALSE)
    */
    private $reserve;

    /**
    * @ORM\ManyToOne(targetEntity="ConsumableStore", inversedBy="consumables")
    * @ORM\JoinColumn(name="consumablestore_id", referencedColumnName="id", nullable=FALSE)
    */
    private $consumablestore;

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
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount;


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
     * Set amount
     *
     * @param integer $amount
     * @return Consumable
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
     * Set reserve
     *
     * @param \GZ\MainBundle\Entity\Reserve $reserve
     * @return Consumable
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

    /**
     * Set consumablestore
     *
     * @param \GZ\MainBundle\Entity\ConsumableStore $consumablestore
     * @return Consumable
     */
    public function setConsumablestore(\GZ\MainBundle\Entity\ConsumableStore $consumablestore)
    {
        $this->consumablestore = $consumablestore;
    
        return $this;
    }

    /**
     * Get consumablestore
     *
     * @return \GZ\MainBundle\Entity\ConsumableStore 
     */
    public function getConsumablestore()
    {
        return $this->consumablestore;
    }
}