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

    public function buildForm(FormBuilderInterface $builder, array $options){

        /*si el formulario es para crear una reserva, se muestra una configuracion*/
        if($this->formtype == 'new'){

            $builder->add('entrydate', 'date', array('label' => 'Fecha de entrada', 'widget' => 'single_text', 'attr' => array('class' => 'datepicker')))
            ->add('exitdate','date',array('label' => 'Fecha de salida','widget' => 'single_text', 'attr' => array('class' => 'datepicker')))
            ->add('roomtype','choice',array('choices' => array('individual' => 'Individual', 'double' => 'Doble'),
            'label'=>'Tipo'))
            ->add('roomcategory','choice',array('choices' => array('standard' => 'Estandar', 'bussiness' => 'Bussiness', 'high' => 'Alta'),
            'label'=>'Categoria'))
            ;

        }else{
            /*si el formulario es para editar una reserva existente, se muestra otra configuracion*/
            $builder->add('entrydate', 'date', array('label' => 'Fecha de entrada', 'widget' => 'single_text', 'attr' => array('disabled' => true)))
            ->add('exitdate','date',array('label' => 'Fecha de salida','widget' => 'single_text', 'attr' => array('disabled' => true)))
            ->add('roomtype','choice',array('choices' => array('individual' => 'Individual', 'double' => 'Doble'),
            'label'=>'Tipo', 'attr' => array('disabled' => true)))
            ->add('roomcategory','choice',array('choices' => array('standard' => 'Estandar', 'bussiness' => 'Bussiness', 'high' => 'Alta'),
            'label'=>'Categoria', 'attr' => array('disabled' => true)))
            ->add('restatus','choice',array('choices' => array('active' => 'Activa', 'occupied' => 'Ocupada', 'canceled' => 'Cancelada', 'complete' => 'Completa'),
            'label'=>'Estado'))
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
            'data_class' => 'Hotel\RoomBundle\Entity\Reserve'
        ));
    }    

    public function getName()
    {
        return 'reserve_form';
    }
}