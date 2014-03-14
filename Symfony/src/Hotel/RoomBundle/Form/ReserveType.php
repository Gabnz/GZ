<?php

namespace Hotel\RoomBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ReserveType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
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
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Hotel\RoomBundle\Entity\Reserve'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'hotel_roombundle_reserve';
    }
}
