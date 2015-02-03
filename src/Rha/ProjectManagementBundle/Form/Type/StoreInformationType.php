<?php

namespace Rha\ProjectManagementBundle\Form\Type;

use Application\GlobalBundle\Form\Type\StoreInformationType as BaseType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StoreInformationType extends BaseType
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('projects', 'collection', array('type' => 'projectinformationtype'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Rha\ProjectManagementBundle\Entity\StoreInformation',
            'compound' => true,
        ));
    }
}
