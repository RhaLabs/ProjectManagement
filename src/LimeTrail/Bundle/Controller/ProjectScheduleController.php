<?php

namespace LimeTrail\Bundle\Controller;

use APY\DataGridBundle\Grid\Source\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
#use APY\DataGridBundle\Grid\Source\Entity;

/**
 * ProjectSchedule controller.
 *
 * @Route("/projectschedule")
 */
class ProjectScheduleController extends Controller
{
    /**
     * Lists all StoreInformation entities.
     *
     * @Route("/", name="limetrail_projectschedule")
     * @Template()
     */
    public function indexAction()
    {
        $source = new Entity('LimeTrailBundle:StoreInformation', 'shells', 'limetrail');

        // Get a grid instance
        $grid = $this->get('grid');

        //manipulate query to reutn only the store projects we want
        $tableAlias = $source->getTableAlias();

        $source->manipulateQuery(
            function ($qb) use ($tableAlias) {
                  $date = new \DateTime(date('Y-m-d'));

                  $qb->andWhere($qb->expr()->eq('_projects_dates.runDate', ':date'))
                     ->andWhere(
                      $qb->expr()->orx(
                        $qb->expr()->gte('_projects_dates.pwoPrj', ':date'),
                        $qb->expr()->isNull('_projects_dates.pwoPrj')
                      )
                    )
                     ->andWhere('_projects_ProjectStatus.name = :n')
                     ->setParameter('n', 'In Progress')
                     ->setParameter('date', $date, \Doctrine\DBAL\Types\Type::DATETIME)
                     ;
            }
        );

        // Set the source
        $grid->setSource($source);

        // Set the selector of the number of items per page
        $grid->setLimits(array(30, 60, 80));

        // Set the default page
        $grid->setDefaultPage(1);

        return $grid->getGridResponse();
    }
}
