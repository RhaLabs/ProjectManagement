<?php

namespace Application\GlobalBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

abstract class DateType extends AbstractType
{
    private $properties;

    public function __construct(array $props)
    {
        $this->properties = $props;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        foreach ($this->properties as $name) {
            switch ($name) {

            case "productionDuration":
              $builder->add($name, 'integer', array(
              'required'    => false,
              ));

            break;

            case "id":
            break;

            default:
            $builder->add($name, 'date', array(
              'input' => 'datetime',
              'widget' => 'single_text',
              'format' => 'yyyy-MM-dd',
              'required'    => false,
              ));

            break;

          }
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LimeTrail\Bundle\Entity\DateOverride',
        ));
    }

    public function getName()
    {
        return 'limetrail_bundle_dateoverride';
    }
}
