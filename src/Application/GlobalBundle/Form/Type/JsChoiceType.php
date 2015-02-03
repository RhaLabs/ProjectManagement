<?php

namespace Application\GlobalBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceListInterface;

/**
 * A choice input whose options are populated by Javascript.
 */
abstract class JsChoiceType extends AbstractType
{
    public function getName()
    {
        return 'js_choice';
    }

    public function getParent()
    {
        return 'choice';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choice_list' => new JsChoiceList(),
            'validation_groups' => false,
        ));
    }
}

abstract class JsChoiceList implements ChoiceListInterface
{
    public function getChoices()
    {
        return array();
    }

    public function getChoicesForValues(array $values)
    {
        return $values;
    }

    public function getIndicesForChoices(array $choices)
    {
        return $choices;
    }

    public function getIndicesForValues(array $values)
    {
        return $values;
    }

    public function getPreferredViews()
    {
        return array();
    }

    public function getRemainingViews()
    {
        return array();
    }

    public function getValues()
    {
        return array();
    }

    public function getValuesForChoices(array $choices)
    {
        return $choices;
    }
}
