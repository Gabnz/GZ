<?php

namespace GZ\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Bill
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Bill
{

    /**
    * @ORM\ManyToOne(targetEntity="\GZ\UserBundle\Entity\User", inversedBy="bills")
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
     * @param \GZ\UserBundle\Entity\User $user
     * @return Bill
     */
    public function setUser(\GZ\UserBundle\Entity\User $user)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \GZ\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add billitems
     *
     * @param \GZ\MainBundle\Entity\BillItems $billitems
     * @return Bill
     */
    public function addBillitem(\GZ\MainBundle\Entity\BillItems $billitems)
    {
        $this->billitems[] = $billitems;
    
        return $this;
    }

    /**
     * Remove billitems
     *
     * @param \GZ\MainBundle\Entity\BillItems $billitems
     */
    public function removeBillitem(\GZ\MainBundle\Entity\BillItems $billitems)
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
}