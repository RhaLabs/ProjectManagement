<?php

namespace Application\GlobalBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * A choice input whose options are populated by Javascript.
 */
abstract class ColorType extends AbstractType
{
    public function getName()
    {
        return 'color';
    }

    public function getParent()
    {
        return 'text';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'compound' => false,
            'max_length' => 7,
            'label' => 'Color Selector',
            'data' => '#ba0d0d',
            'required' => false,
        ));
    }
}
