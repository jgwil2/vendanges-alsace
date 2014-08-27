<?php

namespace Me\VendangesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MotdepasseOublieType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('email', 'text');
	}

	public function getName()
	{
		return 'MotdepasseOublie';
	}
}