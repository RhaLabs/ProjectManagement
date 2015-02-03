<?php

namespace Rha\ProjectManagementBundle\Form\Type;

use Application\GlobalBundle\Form\Type\ProjectInformationType as BaseType;
use Doctrine\ORM\EntityManager;
use Rha\ProjectManagementBundle\Form\DataTransformer\ProjectTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProjectInformationType extends BaseType
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new ProjectTransformer($this->em);
        $builder->addModelTransformer($transformer);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Rha\ProjectManagementBundle\Entity\ProjectInformation',
            'compound' => true,
        ));
    }

    public function getParent()
    {
        return 'text';
    }
}
