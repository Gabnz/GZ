<?php

namespace Hotel\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity
 * @UniqueEntity(fields="email", message="Este correo ya esta registrado.")
 */
class User
{

    /**
    * @ORM\OneToMany(targetEntity="\Hotel\RoomBundle\Entity\Reserve", mappedBy="user")
    */
    private $reserves;

    /**
    * @ORM\OneToMany(targetEntity="\Hotel\BillBundle\Entity\Bill", mappedBy="user")
    */
    private $bills;

    public function __construct()
    {
        $this->reserves = new ArrayCollection();

        $this->bills = new ArrayCollection();

        $this->role = 'standard';
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
     * @ORM\Column(name="pass", type="string", length=50)
     * @Assert\NotBlank(message="Porfavor introduzca una contrasena.")
     * @Assert\Regex(
     *      pattern="/[a-zA-Z0-9]+/",
     *      match=true,
     *      message="Porfavor introduzca una contrasena valida."
     *  )
     * @Assert\Length(max = 4096)
     */
    private $pass;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=50)
     * @Assert\NotBlank(message="Porfavor introduzca su nombre.")
     * @Assert\Regex(
     *      pattern="/^[a-zA-Z][\S]*$/",
     *      match=true,
     *      message="Porfavor introduzca un solo nombre que sea valido."
     *  )
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=50)
     * @Assert\NotBlank(message="Porfavor introduzca su apellido.")
     * @Assert\Regex(
     *      pattern="/^[a-zA-Z][\S]*$/",
     *      match=true,
     *      message="Porfavor introduzca un solo apellido que sea valido."
     *  )
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100)
     * @Assert\NotBlank(message = "Porfavor introduzca su correo.")
     * @Assert\Email(message = "El correo '{{ value }}' no es valido.")
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=10)
     * @Assert\NotBlank(message = "Porfavor introduzca un genero.")
     * @Assert\Choice(choices = {"male", "female"}, message = "Porfavor elija un genero valido.")
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="idcard", type="string", length=20)
     * @Assert\NotBlank(message="Porfavor introduzca su cedula.")
     * @Assert\Regex(
     *      pattern="/^[1-9][0-9]*$/",
     *      match=true,
     *      message="Porfavor introduzca una cedula valida."
     *  )
     */
    private $idcard;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthdate", type="date")
     * @Assert\NotBlank(message="Porfavor introduzca su fecha de nacimiento.")
     * @Assert\Date(message="Porfavor introduzca una fecha valida.")
     */
    private $birthdate;

    /**
     * @var string
     *
     * @ORM\Column(name="creditcard", type="string", length=16)
     * @Assert\NotBlank(message="Porfavor introduzca el numero de su tarjeta de credito.")
     * @Assert\Regex(
     *      pattern="/^[0-9]*$/",
     *      match=true,
     *      message="Porfavor introduzca un numero de tarjeta de credito valido."
     *  )
     * @Assert\Length(
     *      min="16",
     *      max="16",
     *      exactMessage="Porfavor introduzca un numero con 16 digitos.")
     */
    private $creditcard;

    /**
     * @var string
     *
     * @ORM\Column(name="account", type="string", length=20)
     * @Assert\NotBlank(message="Porfavor introduzca un tipo de cuenta.")
     * @Assert\Choice(choices = {"current", "saving"}, message = "Porfavor elija un tipo de cuenta valido.")
     */
    private $account;

    /**
     * @var string
     *
     * @ORM\Column(name="nationality", type="string", length=20)
     * @Assert\NotBlank(message="Porfavor introduzca una nacionalidad.")
     * @Assert\Choice(choices = {"venezuelan", "foreign"}, message = "Porfavor elija una nacionalidad valida.")
     */
    private $nationality;

    /**
     * @var string
     *
     * @ORM\Column(name="rif", type="string", length=20)
     * @Assert\NotBlank(message="Porfavor introduzca su RIF.")
     * @Assert\Regex(
     *      pattern="/^[JV]-[1-9][0-9]*-\d$/",
     *      match=true,
     *      message="Porfavor introduzca un RIF valido."
     *  )
     */
    private $rif;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=10)
     * @Assert\NotBlank(message="Porfavor introduzca un rol.")
     */
    private $role;


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
     * Set pass
     *
     * @param string $pass
     * @return User
     */
    public function setPass($pass)
    {
        $this->pass = $pass;
    
        return $this;
    }

    /**
     * Get pass
     *
     * @return string 
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    
        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    
        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    
        return $this;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set idcard
     *
     * @param string $idcard
     * @return User
     */
    public function setIdcard($idcard)
    {
        $this->idcard = $idcard;
    
        return $this;
    }

    /**
     * Get idcard
     *
     * @return string 
     */
    public function getIdcard()
    {
        return $this->idcard;
    }

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     * @return User
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    
        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime 
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set creditcard
     *
     * @param string $creditcard
     * @return User
     */
    public function setCreditcard($creditcard)
    {
        $this->creditcard = $creditcard;
    
        return $this;
    }

    /**
     * Get creditcard
     *
     * @return string 
     */
    public function getCreditcard()
    {
        return $this->creditcard;
    }

    /**
     * Set account
     *
     * @param string $account
     * @return User
     */
    public function setAccount($account)
    {
        $this->account = $account;
    
        return $this;
    }

    /**
     * Get account
     *
     * @return string 
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set nationality
     *
     * @param string $nationality
     * @return User
     */
    public function setNationality($nationality)
    {
        $this->nationality = $nationality;
    
        return $this;
    }

    /**
     * Get nationality
     *
     * @return string 
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * Set rif
     *
     * @param string $rif
     * @return User
     */
    public function setRif($rif)
    {
        $this->rif = $rif;
    
        return $this;
    }

    /**
     * Get rif
     *
     * @return string 
     */
    public function getRif()
    {
        return $this->rif;
    }

    /**
     * Set role
     *
     * @param string $role
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;
    
        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Add reserves
     *
     * @param \GZ\MainBundle\Entity\Reserve $reserves
     * @return User
     */
    public function addReserve(\GZ\MainBundle\Entity\Reserve $reserves)
    {
        $this->reserves[] = $reserves;
    
        return $this;
    }

    /**
     * Remove reserves
     *
     * @param \GZ\MainBundle\Entity\Reserve $reserves
     */
    public function removeReserve(\GZ\MainBundle\Entity\Reserve $reserves)
    {
        $this->reserves->removeElement($reserves);
    }

    /**
     * Get reserves
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReserves()
    {
        return $this->reserves;
    }



    /**
     * Add bills
     *
     * @param \GZ\MainBundle\Entity\Bill $bills
     * @return User
     */
    public function addBill(\GZ\MainBundle\Entity\Bill $bills)
    {
        $this->bills[] = $bills;
    
        return $this;
    }

    /**
     * Remove bills
     *
     * @param \GZ\MainBundle\Entity\Bill $bills
     */
    public function removeBill(\GZ\MainBundle\Entity\Bill $bills)
    {
        $this->bills->removeElement($bills);
    }

    /**
     * Get bills
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBills()
    {
        return $this->bills;
    }
}