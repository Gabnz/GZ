<?php

namespace Hotel\RoomBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class PhoneCallType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('calldate', 'date', array('label' => 'Fecha de llamada', 'widget' => 'single_text', 'attr' => array('class' => 'datepicker')))
            ->add('starttime', 'time', array('label' => 'Hora de inicio'))
            ->add('endtime', 'time', array('label' => 'Hora de terminacion'))
            ->add('phonenumber', 'text', array('label' => 'Numero de telefono'))
            ->add('calltype', 'choice', array('choices' => array('national' => 'Nacional', 'international' => 'Internacional'),
            'label'=>'Tipo de llamada'))
            ->add('reserve', 'entity', array('class' => 'HotelRoomBundle:Reserve','property' => 'id',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->where('r.restatus = :occupied')
                        ->setParameter('occupied', 'occupied')
                    ;
                }
                ,
            'label' => 'Reservas ocupadas'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Hotel\RoomBundle\Entity\PhoneCall'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'hotel_roombundle_phonecall';
    }
}
