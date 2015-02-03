<?php

namespace Rha\ProjectManagementBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Rha\ProjectManagementBundle\Entity\ProjectCriteria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProjectCriteriaType extends AbstractType
{
    private $properties;

    public function __construct(EntityManager $em)
    {
        $props = $em->getClassMetadata(get_class(new ProjectCriteria()))->getReflectionProperties();
        $propNames = array();
        foreach ($props as $prop) {
            if ($prop->isProtected()) {
                $name = $prop->getName();
                $propNames[] = $name;
            }
        }
        $this->properties = $propNames;
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

      foreach ($this->properties as $name) {
          switch ($name) {
            case "ArchitectOfRecord":
              $builder->add($name, new ContactType());
            break;
            case "project":
              $builder->add($name, 'projectinformationtype');
            case "predesign":
            case "production":
            case "permit":
            case "constructionAdministration":
            case "calculation":
              $builder->add($name, 'text', array(
                'required' => false,
                )
              );
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
            'data_class' => 'Rha\ProjectManagementBundle\Entity\ProjectCriteria',
            'compound' => true,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'project_criteria';
    }
}
