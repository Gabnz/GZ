<?php

namespace GZ\MainBundle\Form\Type;
 
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
 
class ReserveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$builder->add('entrydate', 'date', array('empty_value' => array('year' => 'Anio', 'month' => 'Mes', 'day' => 'Dia'),
            'label' => 'Fecha de entrada','years' => range(date('Y'),date('Y') + 1),
            'widget' => 'single_text',
            ))
    	->add('exitdate','date',array('empty_value' => array('year' => 'Anio', 'month' => 'Mes', 'day' => 'Dia'),
            'label' => 'Fecha de salida','years' => range(date('Y'),date('Y') + 1),
            'widget' => 'single_text',
            ))
        ->add('roomcategory', 'hidden')
    	->add('roomtype','choice',array('choices' => array('individual' => 'Individual', 'double' => 'Doble'),
    		'label'=>'Tipo'))
    	->add('childbeds','choice',array( 'choices' => array(0 => '0', 1 => '1', 2 => '2', 3 => '3'), 'label' => 'Camas infantiles'));
    }

    public function getName()
    {
        return 'reserve_form';
    }
}