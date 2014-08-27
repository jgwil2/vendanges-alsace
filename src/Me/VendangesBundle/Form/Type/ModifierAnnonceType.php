<?php

namespace Me\VendangesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ModifierAnnonceType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('titre', 'text')
			->add('dateDebut', 'date', array('years' => range(date('Y'), date('Y') + 5)))
			->add('dateFin', 'date', array('years' => range(date('Y'), date('Y') + 5)))
			->add('logement', 'checkbox')
			->add('repas', 'checkbox')
			->add('remuneration', 'text')
			->add('texte', 'textarea')
			->add('places', 'text')
			->add('active', 'checkbox');
	}

	public function getName()
	{
		return 'modifierAnnonce';
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
	    $resolver->setDefaults(array(
	        'data_class' => 'Me\VendangesBundle\Entity\Annonce',
	    ));
	}
}