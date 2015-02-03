<?php

namespace Application\GlobalBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

abstract class ProjectInformationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Application\GlobalBundle\Entity\ProjectInformation',
        ));
    }

    public function getName()
    {
        return 'projectinformationtype';
    }

    public function getParent()
    {
        return 'text';
    }
}
