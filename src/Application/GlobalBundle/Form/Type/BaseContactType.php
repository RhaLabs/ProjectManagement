<?php

namespace Application\GlobalBundle\Form\Type;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Application\GlobalBundle\Entity\Company;

abstract class BaseContactType extends AbstractType
{
    public function __construct()
    {
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /*$builder->addEventListener(FormEvents::PRE_SET_DATA, function ($event) {
          $form = $event->getForm();
          $form->remove('officeAddress');
        }, 900);*/

        $builder
            ->add('companyName', 'text', array(
                          'mapped' => false,
                          'constraints' => array(
                              new NotBlank(),
                          ),
                  ))
            ->add('officeAddress', new JsChoiceType(), array(
                      'mapped' => false,
            ))
            ->add('firstName')
            ->add('middleName')
            ->add('lastName')
            ->add('jobTitle')
            ->add('directPhone')
            ->add('mobilePhone')
            ->add('email')
            ->add('website')
        ;

        /*$formModifier = function (FormInterface $form, Company $company) {
          $offices = $company->getOffices();
          $form->add('office', 'collection', array('type' => new OfficeFormType())
                     );
        };

        $provider = $this->provider;

        $builder->addEventListener(
          FormEvents::PRE_SET_DATA,
          function (FormEvent $event) use ($formModifier, $provider) {
            $form = $event->getForm();//$data = $event->getData();
            $data = $form->get('companyName')->getData();
            $company = $data == null ? new Company() : $provider->getCompany($data);
            $formModifier($event->getForm(), $company);
          }
        );

        $builder->get('sport')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $sport = $event->getForm()->getData();

                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!
                $formModifier($event->getForm()->getParent(), $sport);
            }
        );*/
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'validation_groups' => false,
            'data_class' => 'Application\GlobalBundle\Entity\Contact',
            'compound' => true,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'contact';
    }
}
