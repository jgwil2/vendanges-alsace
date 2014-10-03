<?php

namespace Me\VendangesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InscriptionVendangeurType extends AbstractType
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
			->add('password', 'password')
			->add('captcha', 'captcha');

    }

    public function getName()
    {
        return 'inscriptionVendangeur';
    }

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
	    $resolver->setDefaults(array(
	        'data_class' => 'Me\VendangesBundle\Entity\Vendangeur',
	    ));
	}
}