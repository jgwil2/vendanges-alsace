<?php

namespace Me\VendangesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ModifierVigneronType extends AbstractType
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
			->add('presentation', 'textarea');
			//->add('photo', 'file');
    }

    public function getName()
    {
        return 'modifierVigneron';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
	    $resolver->setDefaults(array(
	        'data_class' => 'Me\VendangesBundle\Entity\Vigneron',
	    ));
	}
}