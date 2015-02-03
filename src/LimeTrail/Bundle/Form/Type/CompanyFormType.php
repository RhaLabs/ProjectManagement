<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LimeTrail\Bundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CompanyFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');

        $builder->add('offices', 'collection', array('type' => new OfficeFormType()));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LimeTrail\Bundle\Entity\Company',
            'required' => true,
            'compound' => true,
            'cascade_validation' => true,
            'error_bubbling' => false,
        ));
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'lime_company';
    }
}
