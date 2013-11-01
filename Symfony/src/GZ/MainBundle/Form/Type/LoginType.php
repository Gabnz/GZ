<?php

namespace GZ\MainBundle\Form\Type;
 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email','text', array('label' => 'Correo',
			'attr' => array('placeholder' => 'tucorreo@ejemplo.com')))
        ->add('pass','password', array('invalid_message' => 'La contrasena es invalida.',
            'label' => 'Cotrasena', 'attr' => array('placeholder' => '**********')));
    }
 
    public function getName()
    {
        return 'login_form';
    }
}