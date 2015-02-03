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
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OfficeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('mainPhone');
        $builder->add('fax');

        $builder->add('address', new AddressFormType());

        $builder->add('state', 'entity', array(
          'class' => 'LimeTrailBundle:State',
          'data_class' => 'LimeTrail\Bundle\Entity\State',
          'em' => 'limetrail',
          'property' => 'name',
          'empty_value' => '',
          'empty_data' => null,
          )
        );
        $builder->add('zip', 'zipcodeform',
          array(
            'constraints' => array(
              new NotBlank(),
              new NotNull(),
            ),
          )
        );

        $formModifier = function (FormInterface $form, $state = null) {
          $entities = $state === null ? array() : $state->getCities();

          $cities = array();
          $cityList = array();

          foreach ($entities as $key => $value) {
              $cities[] = array(
                          'id' => $value->getId(),
                          'city' => $value->getName(),
                          'entity' => $value,
                        );
              $cityList[$key] = $value->getName();
          }

          array_multisort($cityList, SORT_ASC, $cities);

          $cityList = array();
          foreach ($cities as $city) {
              $cityList[] = $city['entity'];
          }

          $form->add('city', 'entity', array(
            'class' => 'LimeTrailBundle:City',
            'em' => 'limetrail',
            'choices' => $cityList,
            'property' => 'name',
            )
          );
        };

        $builder->addEventListener(
          FormEvents::PRE_SET_DATA,
          function (FormEvent $event) use ($formModifier) {
            // $data should be the LimeTrailBundle:Office entity
            $data = $event->getData();

            $formModifier($event->getForm(), $data->getState());
          }
        );

        $builder->get('state')->addEventListener(
          FormEvents::POST_SUBMIT,
          function (FormEvent $event) use ($formModifier) {
            $state = $event->getForm()->getData();

            $formModifier($event->getForm()->getParent(), $state);
          }
        );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LimeTrail\Bundle\Entity\Office',
            'required' => true,
            'compound' => true,
            'cascade_validation' => true,
            'by_reference' => false,
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
