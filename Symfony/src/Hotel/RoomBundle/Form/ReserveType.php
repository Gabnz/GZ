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

        if($this->formtype == 'new' || $this->formtype == 'new_admin'){

            $builder
            ->add('entrydate', 'date', array('label' => 'Fecha de entrada', 'widget' => 'single_text', 'attr' => array('class' => 'datepicker')))
            ->add('exitdate','date',array('label' => 'Fecha de salida','widget' => 'single_text', 'attr' => array('class' => 'datepicker')))
            ->add('roomtype','choice',array('choices' => array('individual' => 'Individual', 'double' => 'Doble'),
            'label'=>'Tipo'))
            ->add('available', 'submit', array('label' => 'Disponibilidad', 'attr' => array('class' => 'small')))
            ->add('childbed', 'checkbox', array( 'label' => 'Cama infantil'))
            ->add('submit', 'submit', array('label' => 'Reservar'))
            ;
        }

        if($this->formtype == 'new_admin'){

            $builder
            ->add('user', 'entity', array('class' => 'HotelUserBundle:User','property' => 'email',
            'label' => 'Usuario'))
            ->add('roomcategory','choice',array('choices' => array('standard' => 'Estandar', 'bussiness' => 'Bussiness', 'high' => 'Alta'),
            'label'=>'Categoria'))
            ;
        }

        if($this->formtype == 'edit'){

            $builder
            ->add('restatus','choice',array('choices' => array('active' => 'Activa', 'occupied' => 'Ocupada', 'canceled' => 'Cancelada', 'complete' => 'Completa'),
            'label'=>'Estado'));
        }
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver){
        
        $options['data_class'] = 'Hotel\RoomBundle\Entity\Reserve';

        if($this->formtype == 'edit')
            $options['validation_groups'] = 'edit';

        $resolver->setDefaults($options);
    }

    public function getName()
    {
        return 'reserve_form';
    }
}