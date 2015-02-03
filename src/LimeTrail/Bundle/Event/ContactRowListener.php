<?php

namespace LimeTrail\Bundle\Event;

use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\DependencyInjection\ContainerAware;
use Thrace\DataGridBundle\Event\RowEvent;
use LimeTrail\Bundle\Builders\ContactsBuilder;
use LimeTrail\Bundle\Entity\Company;
use LimeTrail\Bundle\Entity\Office;
use LimeTrail\Bundle\Entity\Contact;

class ContactRowListener extends ContainerAware
{
    /*
    The Form passed in RowEvent contains the follwoing:
    JobRole: id of the jobrole
    Contact: id of the contact
    ProjectId: id of the project
    oper: the grid operation i.e. add
    id: _empty
    */

  public function onRowAdd(RowEvent $event)
  {
      if ($event->getDataGridName() != ContactsBuilder::IDENTIFIER) {
          return;
      }

      $em = $this->container->get('doctrine')->getManager('limetrail');

      $contactprovider = $this->container->get('lime_trail_contact.provider');

      $request = $this->container->get('request');

      $csrfValidator = $this->container->get('data_grid_csrf.provider');

      if (true === $csrfValidator->ValidateGridToken()) {
          $jobrole = $contactprovider->findJobRoleById(
         $request->get('JobRole')
        );
          $contact = $contactprovider->findContactById($request->get('Contact'));
          $project = $em->getRepository('LimeTrailBundle:ProjectInformation')->findOneById($request->get('ProjectId'));

          $projectcontact = $contactprovider->createProjectContact($project, $jobrole, $contact);

          $this->process($projectcontact, $contact, $event);
      } else {
          $errors = array(
        'Invalid Token',
      );

          $event->setSuccess(false);
          $event->setErrors($errors);
      }
  }

    public function onRowDelete(RowEvent $event)
    {
        if ($event->getDataGridName() != ContactsBuilder::IDENTIFIER) {
            return;
        }

        $csrfValidator = $this->container->get('data_grid_csrf.provider');

        if (true === $csrfValidator->ValidateGridToken()) {
            $contactprovider = $this->container->get('lime_trail_contact.provider');

            $contact = $contactprovider->findContactById(
          $this->container->get('request')->request->get('id')
        );

            if (!$contact) {
                throw new EntityNotFoundException();
            }

            $this->container->get('doctrine')->getManager('limetrail')->remove($contact);
            $this->container->get('doctrine')->getManager('limetrail')->flush();

            $event->setSuccess(true);
        } else {
            $errors = array(
        'Invalid Token',
      );

            $event->setSuccess(false);
            $event->setErrors($errors);
        }
    }

    /*
    The Form passed in RowEvent contains the follwoing:
    firstName:Hank
    middleName:
    lastName:Mandziara
    jobTitle:
    directPhone:
    mobilePhone:
    email:mtoika@addisonfire.org
    Company:Warwick Sewer Authority
    address:312
    chartColor: hexidecimal
    oper:edit
    id:902
    */

  public function onRowEdit(RowEvent $event)
  {
      if ($event->getDataGridName() != ContactsBuilder::IDENTIFIER) {
          return;
      }

      $csrfValidator = $this->container->get('data_grid_csrf.provider');

      if (true === $csrfValidator->ValidateGridToken()) {
          $em = $this->container->get('doctrine')->getManager('limetrail');

          $contactprovider = $this->container->get('lime_trail_contact.provider');

          $companyprovider = $this->container->get('lime_trail_company.provider');

          $request = $this->container->get('request');

          $contact = $contactprovider->findContactById($request->get('id'));

          $contact->setFirstName($contactprovider->formatNames($request->get('firstName')))
              ->setMiddleName($contactprovider->formatNames($request->get('middleName')))
              ->setLastName($contactprovider->formatNames($request->get('lastName')))
              ->setJobTitle($request->get('jobTitle'))
              ->setDirectPhone($request->get('directPhone'))
              ->setMobilePhone($request->get('mobilePhone'))
              ->setEmail($request->get('email'))
              ->setChartColor($request->get('chartColor'));

          $company = $companyprovider->getCompany($request->get('Company'));
          $office = $companyprovider->getOfficeById($request->get('address'));

          $contact->addOffice($office);

          $this->process($contact, $event);
      } else {
          $errors = array(
        'Invalid Token',
      );

          $event->setSuccess(false);
          $event->setErrors($errors);
      }
  }

    protected function process(Contact $contact, RowEvent $event)
    {
        $errors = $this->container->get('validator')->validate($contact);

        if ($errors->count() > 0) {
            $event->setErrors($this->errorsToArray($errors));
            $event->setSuccess(false);
        } else {
            $this->container->get('doctrine')->getManager('limetrail')->persist($contact);
            $this->container->get('doctrine')->getManager('limetrail')->flush();
            $event->setSuccess(true);
        }
    }

    protected function errorsToArray($errors)
    {
        $data = array();
        foreach ($errors as $error) {
            $data[] = $error->getMessage();
        }

        return $data;
    }
}
