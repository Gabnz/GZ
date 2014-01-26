<?php

namespace Hotel\UserBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Login{
	
   /**
     * @var string
     *
     * @Assert\NotBlank(message = "Porfavor introduzca su correo.")
     * @Assert\Email(message = "El correo '{{ value }}' no es valido.")
     */
	private $email;

	/**
	 * @var string
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
}