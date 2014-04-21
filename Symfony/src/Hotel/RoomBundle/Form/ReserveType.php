<?php

namespace Hotel\RoomBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class ReserveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('entrydate', 'date', array('label' => 'Fecha de entrada', 'widget' => 'choice'))
        ->add('exitdate','date',array('label' => 'Fecha de salida','widget' => 'choice'))
        ->add('roomcategory','choice',array('choices' => array('standard' => 'Estandar', 'bussiness' => 'Bussiness', 'high' => 'Alta'),
            'label'=>'Categoria'))
        ->add('roomtype','choice',array('choices' => array('individual' => 'Individual', 'double' => 'Doble'),
            'label'=>'Tipo'))
        ->add('childbed', 'checkbox', array( 'label' => 'Cama infantil'))
        //->add('restatus','choice',array('choices' => array('active' => 'Activa', 'occupied' => 'Ocupada', 'canceled' => 'Cancelada', 'complete' => 'Completa'),
        //    'label'=>'Estado'))
        ;
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

/*

class ReserveType extends AbstractType
{
    
     // @param FormBuilderInterface $builder
     // @param array $options
     
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('childbeds')
            ->add('entrydate')
            ->add('exitdate')
            ->add('roomcategory')
            ->add('roomtype')
            ->add('roomstatus')
            ->add('special')
            ->add('user')
            ->add('room')
        ;
    }
    
    //
     // @param OptionsResolverInterface $resolver
     //
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Hotel\RoomBundle\Entity\Reserve'
        ));
    }

    //
     // @return string
     //
    public function getName()
    {
        return 'hotel_roombundle_reserve';
    }
}
*/