<?php

namespace Rha\ProjectManagementBundle\Form\Type;

use Application\GlobalBundle\Form\Type\BaseContactType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactType extends BaseContactType
{
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'validation_groups' => false,
            'data_class' => 'Rha\ProjectManagementBundle\Entity\Contact',
            'compound' => true,
        ));
    }
}
