<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\GlobalBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

abstract class OfficeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('mainPhone');
        $builder->add('fax');

        $builder->add('address', 'entity', array(
                                            'class' => 'LimeTrailBundle:Address',
                                            'property' => 'address',
                                            'property' => 'suite',
                                            'em' => 'limetrail',
                                            'query_builder' => function (EntityRepository $repo) {
                                              return $repo->createQueryBuilder('u');
                                            }, ));
        /*$builder->add('city', 'entity', array(
                                            'class' => 'LimeTrailBundle:City',
                                            'property' => 'name',
                                            'property' => 'url',
                                            'em' => 'limetrail',
                                            'query_builder' => function (EntityRepository $repo) {
                                              return $repo->createQueryBuilder('u');
                                            }));*/
        $builder->add('state', 'entity', array(
                                            'class' => 'LimeTrailBundle:State',
                                            'property' => 'name',
                                            //'property' => 'url',
                                            'em' => 'limetrail',
                                            'query_builder' => function (EntityRepository $repo) {
                                              return $repo->createQueryBuilder('u');
                                            }, ));
        $builder->add('zip', 'entity', array(
                                            'class' => 'LimeTrailBundle:Zip',
                                            'property' => 'zipcode',
                                            'em' => 'limetrail',
                                            'query_builder' => function (EntityRepository $repo) {
                                              return $repo->createQueryBuilder('u');
                                            }, ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LimeTrail\Bundle\Entity\Office',
            'required' => true,
            'compound' => true,
        ));
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'lime_office';
    }
}
