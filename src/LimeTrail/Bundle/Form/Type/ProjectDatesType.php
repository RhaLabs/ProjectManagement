<?php

namespace LimeTrail\Bundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProjectDatesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ProjectType', new ProjectTypeType())

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
