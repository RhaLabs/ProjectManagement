<?php

namespace Rha\ProjectManagementBundle\Form\Type;

use Application\GlobalBundle\Form\Type\BaseCityType as BaseType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CityType extends BaseType
{
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'validation_groups' => false,
            'data_class' => 'Rha\ProjectManagementBundle\Entity\City',
            'compound' => true,
        ));
    }
}
