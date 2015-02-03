<?php

namespace LimeTrail\Bundle\Event;

use Symfony\Component\DependencyInjection\ContainerAware;
use Thrace\DataGridBundle\Event\DataEvent;
use LimeTrail\Bundle\Builders\DatesBuilder;

class DatesDataListener extends ContainerAware
{
    public function onDataReady(DataEvent $event)
    {
        $datagrid = $event->getDataGridName();

        switch ($datagrid) {
      case DatesBuilder::IDENTIFIER:
          //$data = $event->getData();

          $session = $this->container->get('session');

          /*$dql = $session->get('querybuilder/aggregate');

          $logger = $this->container->get('logger');

          $logger->info(print_r($dql, true));


          $em = $this->container->get('doctrine')->getManager('limetrail');

          $request = $this->container->get('request');

          $project = $em->getRepository('LimeTrailBundle:ProjectInformation')->findOneById($request->get('id'));

          $project->setProjectNumber($request->get('projectNumber'))
                 ->setCanonicalName($request->get('ProjectName'));

          $store = $this->container->get('lime_trail_store.provider')->findProjectById($request->get('id'));


          $event->setData($data);*/

          $session->remove('querybuilder/dql');

          $session->remove('querybuilder/n');

          $session->remove('querybuilder/d');

          $session->remove('querybuilder/date');

         break;
    default:
         break;
    }
    }
}
