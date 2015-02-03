<?php

namespace LimeTrail\Bundle\Event;

use LimeTrail\Bundle\Builders\ProjectinformationBuilder;
use LimeTrail\Bundle\Builders\ProjectsContactBuilder;
use LimeTrail\Bundle\Builders\CustomStoreInformationBuilder;
use LimeTrail\Bundle\Builders\DatesBuilder;
use LimeTrail\Bundle\Builders\StoresByClientBuilder;
use LimeTrail\Bundle\Builders\ProjectScheduleBuilder;
use LimeTrail\Bundle\Builders\ProjectChangeBuilder;
use Rha\ProjectManagementBundle\Builders\ProjectBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Thrace\DataGridBundle\Event\QueryBuilderEvent;
use Thrace\DataGridBundle\Event\DataEvent;

class DataGridListener
{
    protected $request;

    protected $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;

        $this->request = $this->requestStack->getCurrentRequest();
    }

    public function onQueryBuilderReady(QueryBuilderEvent $event)
    {
        $gridname = $event->getDataGridName();

        switch ($gridname) {
          case ProjectinformationBuilder::IDENTIFIER:
            $number = $this->request->getSession()->get('projectInfoId');
            //$this->request->getSession()->remove('projectInfoId');

            if (isset($number)) {
                $qb = $event->getQueryBuilder();
                $qb->andWhere('s.storeNumber = :storenumber')->setParameter('storenumber', $number);
                $event->setQueryBuilder($qb);
            }
            break;

            case ProjectsContactBuilder::IDENTIFIER:
              $id = $this->request->getSession()->get('contactId');
              //$this->request->getSession()->remove('contactId');
              $qb = $event->getQueryBuilder();
              $qb->andWhere('p.id = :pid')->setParameter('pid', $id);
              $event->setQueryBuilder($qb);
            break;
            
            case ProjectChangeBuilder::IDENTIFIER:
              $id = $this->request->getSession()->get('lime_trail_project_change/id');
              //$this->request->getSession()->remove('contactId');
              $qb = $event->getQueryBuilder();
              /*
              $qb->addSelect(
                "(SELECT
                    GROUP_CONCAT( s.name, s.date SEPARATOR '; ')
                    FROM LimeTrail\Bundle\Entity\ChangeScope s
                    JOIN s.change ch
                    WHERE
                      ch.id = c.id) AS Scope"
              );*/
              $qb->andWhere('p.id = :pid')->setParameter('pid', $id);
              
              $event->setQueryBuilder($qb);
            break;

            case ProjectBuilder::IDENTIFIER:
              $date = new \DateTime(date('Y-m-d'));

              $past = clone $date;

              $qb = $event->getQueryBuilder();
              $qb->andWhere('j.jobRole = :role')
                 ->andWhere($qb->expr()->eq('d.runDate', ':date'))
                 ->andWhere(
                  $qb->expr()->orx(
                    $qb->expr()->gte('d.goAct', ':d'),
                    $qb->expr()->isNull('d.goAct')
                  )
                )
                 ->andWhere('ps.name = :n')
                 ->setParameter('n', 'Active')
                 ->setParameter('role', 'RHA Project Manager')
                 ->setParameter('date', $date, \Doctrine\DBAL\Types\Type::DATETIME)
                 ->setParameter('d', $past->sub(new \DateInterval('P31D')), \Doctrine\DBAL\Types\Type::DATETIME)
                 ;
            break;

            case StoresByClientBuilder::IDENTIFIER:
              $name = $this->request->getSession()->get('clientName');
              $qb = $event->getQueryBuilder();
              if ($name === 'walmart') {
                  $date = new \DateTime(date('Y-m-d'));
                  $past = clone $date;

                  $qb
                  ->andWhere(
                    $qb->expr()->orx(
                        $qb->expr()->eq('j.jobRole', ':dpm'),
                        $qb->expr()->eq('j.jobRole', ':saam')
                      )
                    )
                  ->andWhere('ps.name = :n')
                  ->andWhere(
                    $qb->expr()->eq('d.runDate', ':date')
                  )
                  ->andWhere(
                    $qb->expr()->orx(
                     $qb->expr()->gte('d.goAct', ':d'),
                     $qb->expr()->isNull('d.goAct')
                    )
                  )
                  ->setParameter('dpm', 'WM Design Project Manager')
                  ->setParameter('saam', 'WM SAAM')
                  ->setParameter('n', 'Active')
                  ->setParameter('date', $date, \Doctrine\DBAL\Types\Type::DATETIME)
                  ->setParameter('d', $past->sub(new \DateInterval('P31D')), \Doctrine\DBAL\Types\Type::DATETIME)
                  ;
              }
              $event->setQueryBuilder($qb);
            break;

            case ProjectScheduleBuilder::IDENTIFIER:
              $date = new \DateTime(date('Y-m-d'));
              $past = clone $date;
              $qb = $event->getQueryBuilder();
              $qb->andWhere('ps.name = :n')
                 ->andWhere(
                   $qb->expr()->orx(
                      $qb->expr()->gte('d.pwoPrj', ':date'),
                      $qb->expr()->isNull('d.pwoPrj')
                    )
                 )
                ;

              if ($this->request->get('_search') === 'false') {
                  $qb->andWhere(
                  $qb->expr()->eq('d.runDate', ':date')
                 );
              } /*else {

                $filters = json_decode($this->request->get('filters', '{}'), true);
               $rules = $filters['rules'];

                foreach ($rules as $rule) {
                 if (in_array("d.runDate",$rule) === true) {
                   $isRunDate = true;
                   break;
                  }
                }

              if (empty($isRunDate)) {
                $qb->andWhere(
                  $qb->expr()->eq('d.runDate', ':date')
                  )
                ;
              }

             }*/

             $qb->setParameter('date', $date, \Doctrine\DBAL\Types\Type::DATETIME)
                  ->setParameter('n', 'Active');

             $event->setQueryBuilder($qb);
            break;

            case DatesBuilder::IDENTIFIER:
            if ($this->request->get('_search') === 'false') {
                $date = new \DateTime(date('Y-m-d'));
                $past = clone $date;
                $qb = $event->getQueryBuilder();
                $qb->andWhere(
                $qb->expr()->eq('d.runDate', ':date')
                )
                ->andWhere('ps.name = :n')
                ->andWhere(
                  $qb->expr()->orx(
                    $qb->expr()->gte('d.goAct', ':d'),
                    $qb->expr()->isNull('d.goAct')
                  )
                )
                ->setParameter('date', $date, \Doctrine\DBAL\Types\Type::DATETIME)
                ->setParameter('n', 'Active')
                ->setParameter('d', $past->sub(new \DateInterval('P31D')), \Doctrine\DBAL\Types\Type::DATETIME);
                $event->setQueryBuilder($qb);

                $session = $this->request->getSession();

                $lastrun = $this->adjustDateForWeekends(clone $date);

                $session->set('querybuilder/dql', $qb->getDql());

                $session->set('querybuilder/n', 'Active');

                $session->set('querybuilder/d', $past);

                $session->set('querybuilder/date', $lastrun);
            } else {
                $filters = json_decode($this->request->get('filters', '{}'), true);
                $rules = $filters['rules'];

                foreach ($rules as $rule) {
                    if (in_array("d.runDate", $rule) === true) {
                        $isRunDate = true;
                        break;
                    }
                }

                if (empty($isRunDate)) {
                    $today = new \DateTime(date('Y-m-d'));
                    $qb = $event->getQueryBuilder();
                    $qb->andWhere(
                  $qb->expr()->eq('d.runDate', ':date')
                  )
                ->setParameter('date', $today, \Doctrine\DBAL\Types\Type::DATETIME);
                    $event->setQueryBuilder($qb);
                }
            }

            break;

          /*case CustomStoreInformationBuilder::IDENTIFIER:
            $qb = $event->getQueryBuilder();
            $qb->Join('pi.contacts', 'pc')
               ->Join('pc.contact', 'u')
               ->andWhere('u.email = :e')
               ->groupBy('si.storeNumber')
               ->setParameter('e', $this->request->get('email'));

            $event->setQueryBuilder($qb);
            break;*/

          default:
            return;
        }
    }

    public function adjustDateForWeekends($date)
    {
        $date->sub(new \DateInterval('P1D'));

        while ((int) $date->format('N') > 5) {
            $date->sub(new \DateInterval('P1D'));
        }

        return $date;
    }

    public function onDataReady(DataEvent $event)
    {
        $data = $event->getData();

      //$data is an array of arrays
      $walker = function (&$value, $key) {
          if ($value instanceof \DateTime) {
              $value = $value;
          } else {
              $value = htmlentities($value);
          }
      };

        array_walk_recursive($data, $walker);

        $event->setData($data);
    }
}
