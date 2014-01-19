<?php

namespace GZ\UserBundle\Form\Type;
 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
 
class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email','text', array('label' => 'Correo', 'attr' => array('placeholder' => 'tucorreo@ejemplo.com')))
        ->add('pass','repeated', array(
            'type' => 'password',
            'invalid_message' => 'Las contrasenas deben coincidir.',
            'first_options' => array('label' => 'Contrasena', 'attr' => array('placeholder' => '**********')),
            'second_options' => array('label' => 'Confirmar', 'attr' => array('placeholder' => '**********'))))
		->add('firstname','text', array('label' => 'Nombre'))
		->add('lastname','text', array('label' => 'Apellido'))
		->add('gender','choice', array('choices' => array('male' => 'Hombre', 'female' => 'Mujer'),
            'label' => 'Genero'))
        ->add('birthdate', 'birthday', array('label' => 'Fecha de nacimiento','widget' => 'single_text',
        'empty_value' => array('year' => 'Anio', 'month' => 'Mes', 'day' => 'Dia')))
        ->add('idcard', 'text', array('label' => 'Cedula'))
        ->add('creditcard', 'text', array('label' => 'Numero de tarjeta de credito'))
        ->add('account', 'choice', array( 'choices' => array('current' => 'Corriente', 'saving' => 'Ahorro'),'label' => 'Tipo de cuenta'))
        ->add('nationality', 'choice', array('choices' => array('venezuelan' => 'Venezolano(a)', 'foreign' => 'Extranjero(a)'),'label' => 'Nacionalidad'))
        ->add('rif', 'text', array('label' => 'RIF'));
    }
 
    public function getName()
    {
        return 'user_form';
    }
}