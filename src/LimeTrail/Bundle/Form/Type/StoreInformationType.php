<?php

namespace LimeTrail\Bundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StoreInformationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('storeNumber')/*
            ->add('city')
            ->add('county')
            ->add('state')*/
            ->add('projects', new ProjectInformationType())
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LimeTrail\Bundle\Entity\StoreInformation',
            'error_bubbling' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'limetrail_bundle_storeinformation';
    }
}
