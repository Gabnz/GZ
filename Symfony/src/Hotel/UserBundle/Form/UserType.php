<?php

namespace Hotel\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
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
        'empty_value' => array('year' => 'Anio', 'month' => 'Mes', 'day' => 'Dia'), 'attr' => array('placeholder' => 'AAAA-MM-DD')))
        ->add('idcard', 'text', array('label' => 'Cedula'))
        ->add('creditcard', 'text', array('label' => 'Numero de tarjeta de credito'))
        ->add('account', 'choice', array( 'choices' => array('current' => 'Corriente', 'saving' => 'Ahorro'),'label' => 'Tipo de cuenta'))
        ->add('nationality', 'choice', array('choices' => array('venezuelan' => 'Venezolano(a)', 'foreign' => 'Extranjero(a)'),'label' => 'Nacionalidad'))
        ->add('rif', 'text', array('label' => 'RIF'));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Hotel\UserBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'hotel_userbundle_user';
    }
}
