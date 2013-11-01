<?php

namespace GZ\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Contact
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Contact
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
     * @ORM\Column(name="message", type="string", length=700)
     * @Assert\NotBlank(message = "Porfavor introduzca su mensaje.")
     */
    private $message;


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
     * Set firstname
     *
     * @param string $firstname
     * @return Contact
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
     * @return Contact
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
     * @return Contact
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
     * Set message
     *
     * @param string $message
     * @return Contact
     */
    public function setMessage($message)
    {
        $this->message = $message;
    
        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }
}