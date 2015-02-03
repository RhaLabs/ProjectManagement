<?php

namespace LimeTrail\Bundle\Event;

use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\DependencyInjection\ContainerAware;
use Thrace\DataGridBundle\Event\RowEvent;
use LimeTrail\Bundle\Builders\ProjectsContactBuilder;
use LimeTrail\Bundle\Entity\JobRole;
use LimeTrail\Bundle\Entity\ProjectContacts;

class ProjectsContactRowListener extends ContainerAware
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
      if ($event->getDataGridName() != ProjectsContactBuilder::IDENTIFIER) {
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
        if ($event->getDataGridName() != ProjectsContactBuilder::IDENTIFIER) {
            return;
        }

        $csrfValidator = $this->container->get('data_grid_csrf.provider');

        if (true === $csrfValidator->ValidateGridToken()) {
            $contactprovider = $this->container->get('lime_trail_contact.provider');

            $projectcontact = $contactprovider->findProjectContactById(
          $this->container->get('request')->request->get('id')
        );

            if (!$projectcontact) {
                throw new EntityNotFoundException();
            }

            $this->container->get('doctrine')->getManager('limetrail')->remove($projectcontact);
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
    JobRole: id of the jobrole
    FirstName: string
    MiddleName: string
    LastName: string
    JobTitle: string
    DirectPhone: string
    MobilePhone: string
    Email: string
    oper: the grid operation i.e. edit
    id: ** ProjectContact id **
    */

  public function onRowEdit(RowEvent $event)
  {
      if ($event->getDataGridName() != ProjectsContactBuilder::IDENTIFIER) {
          return;
      }
      $em = $this->container->get('doctrine')->getManager('limetrail');

      $contactprovider = $this->container->get('lime_trail_contact.provider');

      $companyprovider = $this->container->get('lime_trail_company.provider');

      $request = $this->container->get('request');

      $csrfValidator = $this->container->get('data_grid_csrf.provider');

      if (true === $csrfValidator->ValidateGridToken()) {
          $jobrole = $contactprovider->findJobRoleById(
          $request->get('JobRole')
        );

          $projectcontact = $contactprovider->findProjectContactById(
         $request->get('id')
       );

          $projectcontact->setJobrole($jobrole);

          $contact = $projectcontact->getContact();

          $contact->setFirstName($contactprovider->formatNames($request->get('FirstName')))
            ->setMiddleName($contactprovider->formatNames($request->get('MiddleName')))
            ->setLastName($contactprovider->formatNames($request->get('LastName')))
            ->setJobTitle($request->get('JobTitle'))
            ->setDirectPhone($request->get('DirectPhone'))
            ->setMobilePhone($request->get('MobilePhone'))
            ->setEmail($request->get('Email'));

          $this->process($projectcontact, $contact, $event);
      } else {
          $errors = array(
        'Invalid Token',
      );

          $event->setSuccess(false);
          $event->setErrors($errors);
      }
  }

    protected function process(ProjectContacts $projectcontact, $contact, RowEvent $event)
    {
        $errors = $this->container->get('validator')->validate($contact);

        if ($errors->count() > 0) {
            $event->setErrors($this->errorsToArray($errors));
            $event->setSuccess(false);
        } else {
            $this->container->get('doctrine')->getManager('limetrail')->persist($projectcontact);
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
