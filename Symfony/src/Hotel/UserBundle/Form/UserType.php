<?php

namespace Hotel\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{

    private $formtype;

    /*constructor que establece si la reserva se va a crear o a editar*/
    public function __construct($type){
        $this->formtype = $type;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options){

        if($this->formtype == 'new'){

            $builder
            ->add('pass','repeated', array('type' => 'password','invalid_message' => 'Las contrasenas deben coincidir.',
            'first_options' => array('label' => 'Contrasena', 'attr' => array('placeholder' => '**********')),
            'second_options' => array('label' => 'Confirmar', 'attr' => array('placeholder' => '**********'))))
            ;
        }

        if ($this->formtype == 'new' || $this->formtype == 'edit') {
            
            $builder
            ->add('email','text', array('label' => 'Correo', 'attr' => array('placeholder' => 'tucorreo@ejemplo.com')))
            ->add('firstname','text', array('label' => 'Nombre'))
            ->add('lastname','text', array('label' => 'Apellido'))
            ->add('gender','choice', array('choices' => array('male' => 'Hombre', 'female' => 'Mujer'),
                'label' => 'Genero'))
            ->add('birthdate', 'date', array('label' => 'Fecha de nacimiento','widget' => 'single_text'
                , 'attr' => array('placeholder' => 'AAAA-MM-DD', 'class' => 'birthdatepicker')))
            ->add('idcard', 'text', array('label' => 'Cedula'))
            ->add('creditcard', 'text', array('label' => 'Numero de tarjeta de credito'))
            ->add('account', 'choice', array( 'choices' => array('current' => 'Corriente', 'saving' => 'Ahorro'),'label' => 'Tipo de cuenta'))
            ->add('nationality', 'choice', array('choices' => array('venezuelan' => 'Venezolano(a)', 'foreign' => 'Extranjero(a)'),'label' => 'Nacionalidad'))
            ->add('rif', 'text', array('label' => 'RIF'))
            ;
        }

        if($this->formtype == 'edit_pass'){
            /*si solo se quiere editar la contrasena*/
            $builder
            ->add('actualpass', 'password', array('mapped' => false, 'label' => 'Contrasena actual', 'attr' => array('placeholder' => '**********')))
            ->add('pass','repeated', array('type' => 'password', 'invalid_message' => 'Las contrasenas deben coincidir.',
                'first_options' => array('label' => 'Contrasena nueva', 'attr' => array('placeholder' => '**********')),
                'second_options' => array('label' => 'Confirmar contrasena nueva', 'attr' => array('placeholder' => '**********'))))
            ;
        }
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver){

        $options['data_class'] = 'Hotel\UserBundle\Entity\User';

        if($this->formtype == 'edit_pass')
            $options['validation_groups'] = 'editpass';

        $resolver->setDefaults($options);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'hotel_userbundle_user';
    }
}
