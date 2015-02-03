<?php

namespace LimeTrail\Bundle\Event;

use Doctrine\ORM\EntityNotFoundException;
use LimeTrail\Bundle\Entity\City;
use LimeTrail\Bundle\Entity\StoreInformation;
use LimeTrail\Bundle\Entity\Zip;
use LimeTrail\Bundle\Builders\StoreInformationBuilder;
use LimeTrail\Bundle\Builders\CustomStoreInformationBuilder;
use Symfony\Component\DependencyInjection\ContainerAware;
use Thrace\DataGridBundle\Event\RowEvent;

class StoreInformationRowListener extends ContainerAware
{
    public function onRowEdit(RowEvent $event)
    {
        $gridname = $event->getDataGridName();

        $csrfValidator = $this->container->get('data_grid_csrf.provider');

        if (true === $csrfValidator->ValidateGridToken()) {
            $request = $this->container->get('request');

            switch ($gridname) {
        case StoreInformationBuilder::IDENTIFIER:
        case CustomStoreInformationBuilder::IDENTIFIER:
      $em = $this->container->get('doctrine')->getManager('limetrail');
      $store = $em->getRepository('LimeTrailBundle:StoreInformation')->findOneById($request->get('id'));

      if (!$store) {
          throw new EntityNotFoundException();
      }
      $city = $em->getRepository('LimeTrailBundle:City')->findOneById(
        $request->get('City')
      );
      if (!$city) {
          throw new EntityNotFoundException();
      }
      $store->addCity($city);
      /*$store->addZip($this->getZipcode($em,
        $this->container->get('request')->request->get('zipcode')
      ));*/
      $logger = $this->container->get('logger');
      $logger->info("preprocess");
      $this->process($store, $event);
        break;
            default:
              return;
      }
        } else {
            $errors = array(
        'Invalid Token',
      );

            $event->setSuccess(false);
            $event->setErrors($errors);
        }
    }

    protected function process(StoreInformation $store, RowEvent $event)
    {
        //$errors = $this->container->get('validator')->validate($store, array('default'));
/*
    if ($errors->count() > 0) {
       $event->setErrors($this->errorsToArray($errors));
       $event->setSuccess(false);
    } else {*/
       $this->container->get('doctrine')->getManager('limetrail')->persist($store);
        $this->container->get('doctrine')->getManager('limetrail')->flush();
        $event->setSuccess(true);
    //}
    }

    protected function errorsToArray($errors)
    {
        $data = array();
        foreach ($errors as $error) {
            $data[] = $error->getMessage();
        }

        return $data;
    }
      // @var $zipcode must be a string
  private function getZipcode($em, $zipcode = null)
  {
      $logger = $this->container->get('logger');
      $logger->info("getZipcode: $zipcode");
      $q = $em->getRepository('LimeTrailBundle:Zip');
      if ($zipcode) {
          $t = $q->findOneByZipcode($zipcode);
          if (!$t) {
              $zip = new Zip();
              $zip->setZipcode($zipcode);
              $this->em->persist($zip);

              return $zip;
          }

          return $t;
      } else {
          $zip = new Zip();
          $zip->setZipcode($zipcode);
          $this->em->persist($zip);

          return $zip;
      }
  }
}
