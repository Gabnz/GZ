<?php

namespace Hotel\RoomBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RoomType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('roomtype','choice',array('choices' => array('individual' => 'Individual',
             'double' => 'Doble'),'label'=>'Tipo'))
            ->add('roomcategory','choice',array('choices' => array('standard' => 'Estandar',
             'bussiness' => 'Bussiness', 'high' => 'Alta'), 'label'=>'Categoria'))
            ->add('tv', 'checkbox', array( 'label' => 'tv'))
            ->add('shower',  'checkbox', array( 'label' => 'Baño'))
            ->add('jacuzzi',  'checkbox', array( 'label' => 'Jacuzzi'))
            ->add('music',  'checkbox', array( 'label' => 'Musica'))
            ->add('massage',  'checkbox', array( 'label' => 'Masaje'))
            ->add('roomstatus', 'choice',array('choices' => array('free' => 'Libre','occupied' => 'Ocupada'),
            'label'=>'Estado'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Hotel\RoomBundle\Entity\Room'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'room_form';
    }
}
