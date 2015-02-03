<?php

namespace LimeTrail\Bundle\Form\Type;

use Doctrine\Common\Persistence\ObjectManager;
use LimeTrail\Bundle\Form\DataTransformer\StateTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StateFormType extends AbstractType
{
    protected $om;

    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

        /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new StateTransformer($this->om);
        $builder->addModelTransformer($transformer);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LimeTrail\Bundle\Entity\State',
            'compound' => true,
            'error_bubbling' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'limetrail_state';
    }

    public function getParent()
    {
        return 'choice';
    }
}
