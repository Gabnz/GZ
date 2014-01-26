<?php

namespace GZ\MainBundle\Form\Type;
 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
 
class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('email','text', array('label' => 'Correo electronico', 'attr' => array('placeholder' => 'tucorreo@ejemplo.com')))
        ->add('message', 'textarea', array('label' => 'Mensaje'));
    }
 
    public function getName()
    {
        return 'contact_form';
    }
}