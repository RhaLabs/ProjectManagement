<?php

namespace Rha\ProjectManagementBundle\Controller;

use APY\DataGridBundle\Grid\Source\Entity;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

 /**
  * @Route("/manage")
  * @Template()
  */
class ManageProjectController extends Controller
{
    /**
     * @Route("/project_assignments", name="rha_project_assignments")
     * @Template()
     */
    public function ProjectAssignmentsAction(Request $request)
    {
        $source = new Entity('LimeTrailBundle:StoreInformation', 'projects_by_manager', 'limetrail');
        
        // Get a grid instance
        $grid = $this->get('grid');
        
        //manipulate query to reutn only the store projects we want
        $tableAlias = $source->getTableAlias();
        
        $source->manipulateQuery(
            function ($qb) use ($tableAlias)
            {
                  $date = new \DateTime(date('Y-m-d'));

                  $past = clone $date;
    
                  $qb->andWhere('_projects_contacts_jobrole.jobRole = :role')
                     ->andWhere($qb->expr()->eq('_projects_dates.runDate', ':date'))
                     ->andWhere(
                      $qb->expr()->orx(
                        $qb->expr()->gte('_projects_dates.goAct', ':d'),
                        $qb->expr()->isNull('_projects_dates.goAct')
                      )
                    )
                     ->andWhere('_projects_ProjectStatus.name = :n')
                     ->setParameter('n', 'Active')
                     ->setParameter('role', 'RHA Project Manager')
                     ->setParameter('date', $date, \Doctrine\DBAL\Types\Type::DATETIME)
                     ->setParameter('d', $past->sub(new \DateInterval('P31D')), \Doctrine\DBAL\Types\Type::DATETIME)
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
