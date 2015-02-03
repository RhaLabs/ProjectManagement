<?php

namespace LimeTrail\Bundle\Event;

use Symfony\Component\DependencyInjection\ContainerAware;
use Thrace\DataGridBundle\Event\RowEvent;
use LimeTrail\Bundle\Builders\DatesBuilder;
use LimeTrail\Bundle\Builders\ProjectinformationBuilder;
use LimeTrail\Bundle\Builders\ProjectScheduleBuilder;

class DatesRowListener extends ContainerAware
{
    /*
    The Form passed in RowEvent contains the follwoing:
      ProjectNumber: text
      City: id
      CommonName: text
      oper:edit
      id: project id
    */

  public function onRowEdit(RowEvent $event)
  {
      $datagrid = $event->getDataGridName();

      $csrfValidator = $this->container->get('data_grid_csrf.provider');

      if (true === $csrfValidator->ValidateGridToken()) {
          switch ($datagrid) {
        case DatesBuilder::IDENTIFIER:
        case ProjectinformationBuilder::IDENTIFIER:
        case ProjectScheduleBuilder::IDENTIFIER:
            $em = $this->container->get('doctrine')->getManager('limetrail');

            $request = $this->container->get('request');

            $project = $em->getRepository('LimeTrailBundle:ProjectInformation')->findOneById($request->get('id'));

            $project->setProjectNumber($request->get('projectNumber'))
                   ->setCanonicalName($request->get('ProjectName'));

            $store = $this->container->get('lime_trail_store.provider')->findProjectById($request->get('id'));

            $cityId = $request->get('City');
            if (isset($cityId)) {
                $cityprovider = $this->container->get('lime_trail_city.provider');

                $city = $cityprovider->findCityById(
                 $request->get('City')
               );
                $store->addCity($city);
            }

            $this->process($project, $store, $event);
           break;
      default:
           break;
      }
      } else {
          $errors = array(
        'Invalid Token',
      );

          $event->setSuccess(false);
          $event->setErrors($errors);
      }
  }

    protected function process($project, $store, RowEvent $event)
    {
        $errors = $this->container->get('validator')->validate($project);

        if ($errors->count() > 0) {
            $event->setErrors($this->errorsToArray($errors));
            $event->setSuccess(false);
        } else {
            $this->container->get('doctrine')->getManager('limetrail')->persist($project);
            $this->container->get('doctrine')->getManager('limetrail')->persist($store);
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
