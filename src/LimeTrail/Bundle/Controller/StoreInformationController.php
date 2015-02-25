<?php

namespace LimeTrail\Bundle\Controller;

use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Column\BlankColumn;
use APY\DataGridBundle\Grid\Export\PHPExcel2007Export;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use LimeTrail\Bundle\Entity\StoreInformation;

/**
 * StoreInformation controller.
 *
 * @Route("/storeinformation")
 */
class StoreInformationController extends Controller
{
    /**
     * Lists all StoreInformation entities.
     *
     * @Route("/", name="limetrail_storeinformation")
     * @Method({"GET","POST"})
     * @Template()
     */
    public function indexAction()
    {
        $source = new Entity('LimeTrailBundle:StoreInformation', 'store_information', 'limetrail');

        // Get a grid instance
        $grid = $this->get('grid');

        // Set the source
        $grid->setSource($source);

        // Set the selector of the number of items per page
        $grid->setLimits(array(5, 10, 15));

        // Set the default page
        $grid->setDefaultPage(1);
        
        // Export
        $grid->addExport(new PHPExcel2007Export('Excel', 'Stores' ));

        return $grid->getGridResponse();
    }
    /**
     * Displays a form to edit an existing Store entity.
     *
     * @Route("/{id}/edit", name="store_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LimeTrailBundle:StoreInformation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StoreInformation entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     *
     * @Route("/projects", name="limetrail_storeinformation_customgrid")
     * @Method("GET")
     * @Template()
     */
    public function customgridAction()
    {
        $securityContext = $this->get('security.context');

        $user = $securityContext->getToken()->getUser();

        $email = $user->getEmailCanonical();

        $source = new Entity('LimeTrailBundle:StoreInformation', 'myProjects', 'limetrail');

        // Get a grid instance
        $grid = $this->get('grid');

        //manipulate query to reutn only the store projects we want
        $tableAlias = $source->getTableAlias();

        $source->manipulateQuery(
            function ($qb) use ($tableAlias, $email) {
                $date_from = new \DateTime(
                  date('Y-m-d',
                    strtotime(
                      date('Y-m-d').
                      " -10 weekdays "
                    )
                  )
                );
                $date_to = new \DateTime(date('Y-m-d'));

                $qb->andWhere(
                      $qb->expr()->eq('_projects_dates.runDate', ':today')
                      )
                   /*->andWhere(
                      $qb->expr()->gte('d.goPrj', ':date_to')
                      )*/
                   ->andWhere('_projects_contacts_contact.email = :e')
                   ->andWhere(
                          $qb->expr()->orx(
                            $qb->expr()->gte('_projects_dates.goAct', ':d'),
                            $qb->expr()->isNull('_projects_dates.goAct')
                          )
                        )
                   ->setParameter('e', $email)
                   ->setParameter('today', $date_to, \Doctrine\DBAL\Types\Type::DATETIME)
                   ->setParameter('d', $date_from, \Doctrine\DBAL\Types\Type::DATETIME)
                ;
            }
        );

        // Set the source
        $grid->setSource($source);
        
        $column = new BlankColumn(array(
            'id' => 'days',
            'title' => 'Days to Possession',
        ));
        
        $column->manipulateRenderCell(function($value, $row, $router) {
            $today = new \DateTime('now');
            $possession = $row->getField('projects.dates.possPrj');
            $days = $today->diff($possession);
            
            return $days->format('%R%a days');
        });
        
        $grid->addColumn($column);

        // Set the selector of the number of items per page
        $grid->setLimits(array(30));

        // Set the default page
        $grid->setDefaultPage(1);

        return $grid->getGridResponse();
    }

    /**
     *
     * @Route("/client/{name}", name="limetrail_storeinformation_walmart_sort")
     * @Method("GET")
     * @Template()
     */
    public function gridByClientAction($name)
    {
        $alias = 'stores_by_client';

        $session = $this->container->get('request')->getSession();

        $session->set('clientName', $name);

        $em = $this->getDoctrine()->getManager('limetrail');

        $qb = $em->getRepository('LimeTrailBundle:ProjectContacts')->createQueryBuilder('pc');

        if ($name === 'walmart') {
            $date = new \DateTime(date('Y-m-d'));
            $past = clone $date;

            $query = 'CONCAT(CONCAT(c.firstName, \' \'), c.lastName)';

            $qb->select($query)
                  ->Join('pc.contact', 'c')
                  ->Join('pc.project', 'p')
                  ->Join('pc.jobrole', 'j')
                  ->leftJoin('p.ProjectType', 'pt')
                  ->leftJoin('p.DevelopmentType', 'dt')
                  ->leftJoin('p.DescriptionOfType', 'des')
                  ->leftJoin('p.ProgramYear', 'py')
                  ->leftJoin('p.Prototype', 'proto')
                  ->leftJoin('p.ProjectStatus', 'ps')
                  ->Join('p.dates', 'd')
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
                  ->setParameter('n', 'In Progress')
                  ->setParameter('date', $date, \Doctrine\DBAL\Types\Type::DATETIME)
                  ->setParameter('d', $past->sub(new \DateInterval('P31D')), \Doctrine\DBAL\Types\Type::DATETIME)
                  ;
        }

        $query = $qb->getQuery();

        $result = $query->getScalarResult();

        $finalResult = array();

        foreach ($result as $entry) {
            $finalResult = array_merge($finalResult, $entry);
        }

        $result = array_count_values($finalResult);

        $source = new Entity('LimeTrailBundle:StoreInformation', 'projects_by_manager', 'limetrail');

        // Get a grid instance
        $grid = $this->get('grid');

        //manipulate query to reutn only the store projects we want
        $tableAlias = $source->getTableAlias();

        $source->manipulateQuery(
            function ($qb) use ($name) {
                if ($name === 'walmart') {
                    $date = new \DateTime(date('Y-m-d'));
                    $past = clone $date;

                    $qb
                  ->andWhere(
                    $qb->expr()->orx(
                        $qb->expr()->eq('_projects_contacts_jobrole.jobRole', ':dpm'),
                        $qb->expr()->eq('_projects_contacts_jobrole.jobRole', ':saam')
                      )
                    )
                  ->andWhere('_projects_ProjectStatus.name = :n')
                  ->andWhere(
                    $qb->expr()->eq('_projects_dates.runDate', ':date')
                  )
                  ->andWhere(
                    $qb->expr()->orx(
                     $qb->expr()->gte('_projects_dates.goAct', ':d'),
                     $qb->expr()->isNull('_projects_dates.goAct')
                    )
                  )
                  ->setParameter('dpm', 'WM Design Project Manager')
                  ->setParameter('saam', 'WM SAAM')
                  ->setParameter('n', 'In Progress')
                  ->setParameter('date', $date, \Doctrine\DBAL\Types\Type::DATETIME)
                  ->setParameter('d', $past->sub(new \DateInterval('P31D')), \Doctrine\DBAL\Types\Type::DATETIME)
                  ;
                }
            }
        );

        // Set the source
        $grid->setSource($source);

        // Set the selector of the number of items per page
        $grid->setLimits(array(30, 60, 80));

        // Set the default page
        $grid->setDefaultPage(1);

        return array(
            'data' => $grid->getGridResponse(), 'result' => $result,
        );
    }

    /**
     * @Route("/{grid}/export", name="limetrail_storeinformation_exportgrid")
     * @Method({"GET","POST"})
     */
    public function exportgridAction($grid)
    {
        $logger = $this->container->get('logger');

        $request = $this->container->get('request');
        $request->headers->set('X-Requested-With', 'XMLHttpRequest');
      //$logger->info(print_r($request, true));

      $gridController = $this->container->get('thrace_data_grid.controller.datagrid');
        $jsonResponse = $gridController->dataAction($grid);

      /*$data = json_decode($jsonResponse->getContent(), true);

      $logger->info(print_r($data, true));*/

      $dataGrid = $gridController->getDataGrid($grid);

        $request->headers->remove('X-Requested-With');

        $queryBuilder = $dataGrid->getQueryBuilder();
        $query = $queryBuilder->getQuery();

        $data = $query->getScalarResult();

        $source = new \Exporter\Source\ArraySourceIterator(
          $data
      );

        $format = 'xls';

        $filename = sprintf('export_%s_%s.%s',
            strtolower($grid),
            date('Y-m-d', strtotime('now')),
            $format
        );
        $logger->info(print_r($filename, true));

        return $this->get('sonata.admin.exporter')->getResponse($format, $filename, $source);
    }
}
