<?php

namespace LimeTrail\Bundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProjectInformationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('projectNumber')/*
            ->add('projectPhase')
            ->add('confidential')
            ->add('combo')
            ->add('manageSitesDifferent')
            ->add('sap')
            ->add('storeSquareFootage')
            ->add('increaseSquareFootage')
            ->add('prjTotalSquareFootage')
            ->add('actTotalSquareFootage')
            ->add('ProjectType', new ProjectTypeType())*/

        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LimeTrail\Bundle\Entity\ProjectInformation',

            'error_bubbling' => false,
        ));
    }

    public function getName()
    {
        return 'limetrail_bundle_projectinformationtype';
    }
}
