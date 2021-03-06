<?php

namespace Hotel\BillBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Bill
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Hotel\BillBundle\Entity\BillRepository")
 */
class Bill
{

    // ManyToOne(targetEntity="\Hotel\UserBundle\Entity\User", cascade={"persist"}, inversedBy="bills")
    /**
    * @ORM\ManyToOne(targetEntity="\Hotel\UserBundle\Entity\User", cascade={"persist"}, inversedBy="bills")
    * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=FALSE)
    */
    private $user;


    /**
    * @ORM\OneToMany(targetEntity="BillItems", mappedBy="bill")
    */
    private $billitems;

    public function __construct()
    {
        $this->billitems = new ArrayCollection();
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
     * @var \DateTime
     *
     * @ORM\Column(name="issuedate", type="date")
     */
    private $issuedate;

    /**
     * @var string
     *
     * @ORM\Column(name="billstatus", type="string", length=20)
     */
    private $billstatus;

     /**
     * @var string
     *
     * @ORM\Column(name="type_bill", type="string", length=20, nullable=TRUE)
     */
    private $type_bill;    

     /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=20, nullable=TRUE)
     */
    private $category;
    
     /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=20, nullable=TRUE)
     */
    private $type;

     /**
     * @var string
     *
     * @ORM\Column(name="category_cost", type="string", length=20, nullable=TRUE)
     */
    private $category_cost;
    
     /**
     * @var string
     *
     * @ORM\Column(name="type_cost", type="string", length=20, nullable=TRUE)
     */
    private $type_cost; 

    /**
     * @var string
     *
     * @ORM\Column(name="housing_days", type="string", length=20, nullable=TRUE)
     */
    private $housing_days;               

    /**
     * @var string
     *
     * @ORM\Column(name="housing_cost", type="string", length=20, nullable=TRUE)
     */
    private $housing_cost;

    /**
     * @var string
     *
     * @ORM\Column(name="items_cost", type="string", length=20, nullable=TRUE)
     */
    private $items_cost;    

    /**
     * @var string
     *
     * @ORM\Column(name="total_cost", type="string", length=20, nullable=TRUE)
     */
    private $total_cost;  

    /**
     * @var string
     *
     * @ORM\Column(name="fail_cost", type="string", length=20, nullable=TRUE)
     */
    private $fail_cost; 

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
     * Set issuedate
     *
     * @param \DateTime $issuedate
     * @return Bill
     */
    public function setIssuedate($issuedate)
    {
        $this->issuedate = $issuedate;
    
        return $this;
    }

    /**
     * Get issuedate
     *
     * @return \DateTime 
     */
    public function getIssuedate()
    {
        return $this->issuedate;
    }

    /**
     * Set billstatus
     *
     * @param string $billstatus
     * @return Bill
     */
    public function setBillstatus($billstatus)
    {
        $this->billstatus = $billstatus;
    
        return $this;
    }

    /**
     * Get billstatus
     *
     * @return string 
     */
    public function getBillstatus()
    {
        return $this->billstatus;
    }

    /**
     * Set user
     *
     * @param \Hotel\UserBundle\Entity\User $user
     * @return Bill
     */
    public function setUser(\Hotel\UserBundle\Entity\User $user)
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
     * Add billitems
     *
     * @param \Hotel\BillBundle\Entity\BillItems $billitems
     * @return Bill
     */
    public function addBillitem(\Hotel\BillBundle\Entity\BillItems $billitems)
    {
        $this->billitems[] = $billitems;
    
        return $this;
    }

    /**
     * Remove billitems
     *
     * @param \Hotel\BillBundle\Entity\BillItems $billitems
     */
    public function removeBillitem(\Hotel\BillBundle\Entity\BillItems $billitems)
    {
        $this->billitems->removeElement($billitems);
    }

    /**
     * Get billitems
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBillitems()
    {
        return $this->billitems;
    }

    /**
     * Set category
     *
     * @param string $category
     * @return Bill
     */
    public function setCategory($category)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return string 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Bill
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set category_cost
     *
     * @param string $categoryCost
     * @return Bill
     */
    public function setCategoryCost($categoryCost)
    {
        $this->category_cost = $categoryCost;
    
        return $this;
    }

    /**
     * Get category_cost
     *
     * @return string 
     */
    public function getCategoryCost()
    {
        return $this->category_cost;
    }

    /**
     * Set type_cost
     *
     * @param string $typeCost
     * @return Bill
     */
    public function setTypeCost($typeCost)
    {
        $this->type_cost = $typeCost;
    
        return $this;
    }

    /**
     * Get type_cost
     *
     * @return string 
     */
    public function getTypeCost()
    {
        return $this->type_cost;
    }

    /**
     * Set housing_days
     *
     * @param string $housingDays
     * @return Bill
     */
    public function setHousingDays($housingDays)
    {
        $this->housing_days = $housingDays;
    
        return $this;
    }

    /**
     * Get housing_days
     *
     * @return string 
     */
    public function getHousingDays()
    {
        return $this->housing_days;
    }

    /**
     * Set housing_cost
     *
     * @param string $housingCost
     * @return Bill
     */
    public function setHousingCost($housingCost)
    {
        $this->housing_cost = $housingCost;
    
        return $this;
    }

    /**
     * Get housing_cost
     *
     * @return string 
     */
    public function getHousingCost()
    {
        return $this->housing_cost;
    }



    /**
     * Set items_cost
     *
     * @param string $itemsCost
     * @return Bill
     */
    public function setItemsCost($itemsCost)
    {
        $this->items_cost = $itemsCost;
    
        return $this;
    }

    /**
     * Get items_cost
     *
     * @return string 
     */
    public function getItemsCost()
    {
        return $this->items_cost;
    }

    /**
     * Set total_cost
     *
     * @param string $totalCost
     * @return Bill
     */
    public function setTotalCost($totalCost)
    {
        $this->total_cost = $totalCost;
    
        return $this;
    }

    /**
     * Get total_cost
     *
     * @return string 
     */
    public function getTotalCost()
    {
        return $this->total_cost;
    }


    /**
     * Set type_bill
     *
     * @param string $type_bill
     * @return Bill
     */
    public function setTypeBill($typeBill)
    {
        $this->type_bill = $typeBill;
    
        return $this;
    }

    /**
     * Get type_bill
     *
     * @return string 
     */
    public function getTypeBill()
    {
        return $this->type_bill;
    }


    /**
     * Set fail_cost
     *
     * @param string $failCost
     * @return Bill
     */
    public function setFailCost($failCost)
    {
        $this->fail_cost = $failCost;
    
        return $this;
    }

    /**
     * Get fail_cost
     *
     * @return string 
     */
    public function getFailCost()
    {
        return $this->fail_cost;
    }



}