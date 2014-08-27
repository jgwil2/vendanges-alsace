<?php

namespace Me\VendangesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AnnonceType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('titre', 'text')
			->add('dateDebut', 'date', array('years' => range(date('Y'), date('Y') + 5)))
			->add('dateFin', 'date', array('years' => range(date('Y'), date('Y') + 5)))
			->add('logement', 'choice', array(
				'choices' => array(
					1 => 'OUI', 0 => 'NON'),
				'expanded' => true))
			->add('repas', 'choice', array(
				'choices' => array(
					1 => 'OUI', 0 => 'NON'),
				'expanded' => true))
			->add('remuneration', 'text')
			->add('texte', 'textarea')
			->add('places', 'text');
	}

	public function getName()
	{
		return 'annonce';
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
	    $resolver->setDefaults(array(
	        'data_class' => 'Me\VendangesBundle\Entity\Annonce',
	    ));
	}
}