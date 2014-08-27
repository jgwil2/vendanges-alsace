<?php

namespace Me\VendangesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ModifierVendangeurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$builder
			->add('prenom', 'text')
			->add('nom', 'text')
			->add('adresse', 'text')
			->add('code', 'text')
			->add('ville', 'text')
			->add('tel', 'text')
			->add('pays', 'text')
			->add('email', 'text')
			->add('pays', 'text')
			->add('tracteur', 'choice', array(
				'choices' => array(
					1 => 'OUI', 0 => 'NON'), 
				'expanded' => true))
			->add('vehicule', 'choice', array(
				'choices' => array(
					1 => 'OUI', 0 => 'NON'), 
				'expanded' => true))
			->add('disponible', 'choice', array(
				'choices' => array(
					1 => 'OUI', 0 => 'NON'), 
				'expanded' => true))
			->add('dateDebut', 'date', array('years' => range(date('Y'), date('Y') + 5)))
			->add('dateFin', 'date', array('years' => range(date('Y'), date('Y') + 5)))
			->add('motivation', 'textarea');
    }

    public function getName()
    {
        return 'modifierVendangeur';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
	    $resolver->setDefaults(array(
	        'data_class' => 'Me\VendangesBundle\Entity\Vendangeur',
	    ));
	}
}