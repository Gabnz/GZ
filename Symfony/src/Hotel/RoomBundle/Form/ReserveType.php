<?php

namespace Hotel\RoomBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class ReserveType extends AbstractType
{
    private $formtype;

    /*constructor que establece si la reserva se va a crear o a editar*/
    public function __construct($type){
        $this->formtype = $type;
    }

    public function validationGroup(){

        if($this->formtype == 'edit')
            return $this->formtype;

        return true;
    }

    public function buildForm(FormBuilderInterface $builder, array $options){

        if($this->formtype == 'new'){
        /*si el formulario es para crear una reserva como usuario estandar, se muestra una configuracion*/
            $builder
            ->add('user', 'hidden')
            ->add('roomcategory', 'hidden')
            ->add('entrydate', 'date', array('label' => 'Fecha de entrada', 'widget' => 'single_text', 'attr' => array('class' => 'datepicker')))
            ->add('exitdate','date',array('label' => 'Fecha de salida','widget' => 'single_text', 'attr' => array('class' => 'datepicker')))
            ->add('roomtype','choice',array('choices' => array('individual' => 'Individual', 'double' => 'Doble'),
            'label'=>'Tipo'))
            ->add('available', 'submit', array('label' => 'Disponibilidad', 'attr' => array('class' => 'small')))
            ;

        }elseif($this->formtype == 'new_admin'){
            /*si el formulario es para crear una reserva como usuario administrador, se muestra otra configuracion*/
            $builder
            ->add('user', 'entity', array('class' => 'HotelUserBundle:User','property' => 'email',
            'label' => 'Usuario'))
            ->add('entrydate', 'date', array('label' => 'Fecha de entrada', 'widget' => 'single_text', 'attr' => array('class' => 'datepicker')))
            ->add('exitdate','date',array('label' => 'Fecha de salida','widget' => 'single_text', 'attr' => array('class' => 'datepicker')))
            ->add('roomtype','choice',array('choices' => array('individual' => 'Individual', 'double' => 'Doble'),
            'label'=>'Tipo'))
            ->add('roomcategory','choice',array('choices' => array('standard' => 'Estandar', 'bussiness' => 'Bussiness', 'high' => 'Alta'),
            'label'=>'Categoria'))
            ->add('available', 'submit', array('label' => 'Disponibilidad', 'attr' => array('class' => 'small')))
            ;

        }else{
            /*si el formulario es para editar una reserva existente, se muestra otra configuracion*/
            $builder
            ->add('entrydate', 'date', array('label' => 'Fecha de entrada', 'widget' => 'single_text', 'attr' => array('readonly' => true)))
            ->add('exitdate','date',array('label' => 'Fecha de salida','widget' => 'single_text', 'attr' => array('readonly' => true)))
            ->add('roomtype','text',array('label'=>'Tipo', 'attr' => array('readonly' => true)))
            ->add('roomcategory','text',array('label'=>'Categoria', 'attr' => array('readonly' => true)))
            ->add('restatus','choice',array('choices' => array('active' => 'Activa', 'occupied' => 'Ocupada', 'canceled' => 'Cancelada', 'complete' => 'Completa'),
            'label'=>'Estado'))
            ->add('special', 'hidden', array( 'label' => 'Caso especial', 'attr' => array('readonly' => true)))
            ;
        }
        $builder->add('childbed', 'checkbox', array( 'label' => 'Cama infantil'));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Hotel\RoomBundle\Entity\Reserve',
            'validation_groups' => array($this->validationGroup())
        ));
    }

    public function getName()
    {
        return 'reserve_form';
    }
}