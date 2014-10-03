<?php

namespace Me\VendangesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InscriptionVigneronType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('nom', 'text')
			->add('adresse', 'text')
			->add('code', 'text')
			->add('ville', 'text')
			->add('site', 'text')
			->add('email', 'text')
			->add('presentation', 'textarea')
			//->add('photo', 'file')
			->add('password', 'password')
			->add('captcha', 'captcha');

    }

    public function getName()
    {
        return 'inscriptionVigneron';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
	    $resolver->setDefaults(array(
	        'data_class' => 'Me\VendangesBundle\Entity\Vigneron',
	    ));
	}
}