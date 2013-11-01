<?php

namespace GZ\MainBundle\Form\Type;
 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
 
class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
		->add('firstname','text', array('label' => 'Nombre'))
		->add('lastname','text', array('label' => 'Apellido'))
        ->add('email','text', array('label' => 'Correo electronico'))
        ->add('message', 'textarea', array('label' => 'Mensaje'))
       //->add('save','submit', array('label' => 'Enviar'))
        ;
    }
 
    public function getName()
    {
        return 'contact_form';
    }
}