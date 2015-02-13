<?php

namespace LimeTrail\Bundle\Form\Type;

use Doctrine\Common\Persistence\ObjectManager;
use LimeTrail\Bundle\Form\DataTransformer\ZipcodeTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ZipFormType extends AbstractType
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
        $transformer = new ZipcodeTransformer($this->om);
        $builder->addModelTransformer($transformer);

        //$builder->add('zipcode');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'compound' => false,
            'error_bubbling' => false,
            'by_reference' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'zipcodeform';
    }

    public function getParent()
    {
        return 'integer';
    }
}
