<?php

namespace LimeTrail\Bundle\Controller;

use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Export\PHPExcel2007Export;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use LimeTrail\Bundle\Entity\ProjectInformation;
use LimeTrail\Bundle\Entity\StoreInformation;
use LimeTrail\Bundle\Entity\DateOverride;
use LimeTrail\Bundle\Form\Type\DateType;

/**
 * StoreInformation controller.
 *
 * @Route("/projectdates")
 */
class ProjectDatesController extends Controller
{
    /**
     *
     * @Route("/aggregated", name="limetrail_projectdates_aggregated")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function aggregateDatesAction()
    {
        $source = new Entity('LimeTrailBundle:StoreInformation', 'trident', 'limetrail');

        // Get a grid instance
        $grid = $this->get('grid');

        //manipulate query to reutn only the store projects we want
        $tableAlias = $source->getTableAlias();

        $source->manipulateQuery(
            function ($qb) use ($tableAlias) {
                $date = new \DateTime(date('Y-m-d'));
                $past = clone $date;

                $qb->andWhere(
                    $qb->expr()->eq('_projects_dates.runDate', ':date')
                )
                //->andWhere('_projects_ProjectStatus.name = :n')
                ->andWhere(
                  $qb->expr()->orx(
                    $qb->expr()->gte('_projects_dates.goAct', ':d'),
                    $qb->expr()->isNull('_projects_dates.goAct')
                  )
                )
                ->setParameter('date', $date, \Doctrine\DBAL\Types\Type::DATETIME)
                //->setParameter('n', 'Active')
                ->setParameter('d', $past->sub(new \DateInterval('P31D')), \Doctrine\DBAL\Types\Type::DATETIME);

            }
        );

        // Set the source
        $grid->setSource($source);

        $grid->setColumnsOrder(
                array(
                    'storeNumber',
                    'city.name',
                    'state.abbreviation',
                    'projects.projectNumber',
                ),
                true
            );

        // Set the selector of the number of items per page
        $grid->setLimits(array(30, 60, 80, 120));
        
        // Export
        $grid->addExport(new PHPExcel2007Export('Excel', 'Project_Dates' ));

        // Set the default page
        $grid->setDefaultPage(1);

        return $grid->getGridResponse();
    }

    /**
     *
     * @Route("/override", name="limetrail_projectdates_override")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function overrideDateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager('limetrail');

        $logger = $this->container->get('logger');

        $project = $em->getRepository('LimeTrailBundle:ProjectInformation')
                    ->find($request->get('projectId'));

        if (!$project) {
            throw $this->createNotFoundException('Unable to find Project.');
        }
        $entity = $project->getDateOverride();
        if (!$entity) {
            $entity = new DateOverride();
        }
        //get properties of Dates
        $props = $em->getClassMetadata(get_class($entity))->getReflectionProperties();
        $propNames = array();
        foreach ($props as $prop) {
            if ($prop->isProtected()) {
                $name = $prop->getName();
                $propNames[] = $name;
            }
        }

        $form = $this->createForm(new DateType($propNames), $entity, array(
          'action' => $this->generateUrl('limetrail_projectdates_override',
                        array('projectId' => $request->get('projectId'))),
          'method' => 'POST',
      ));

        $form->add('submit', 'submit', array('label' => 'Add Override'));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $project->addDateOverride($entity);
            $em->persist($entity);
            $em->persist($project);
            $em->flush();

            return $this->redirect($this->generateUrl('rha_project_forecast'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $form->createView(),
        );
    }

    /**
     *
     * @Route("/cell_change", name="limetrail_datagrid_cell_change")
     * @Method("POST")
     */
    public function cellChangeAction(Request $request)
    {
        $storeProvider = $this->container->get('lime_trail_store.provider');

        $project = $storeProvider->findCurrentProjectDates($request->get('store_id'), new \DateTime(date('Y-m-d')));

      // getDates() returns a Doctrine/ArrayCollection
      $datesCollection = $project->getDates();

      //the ArrayCollection has only one entity in it becuase we retrieved it from the findCurrentProjectsDates() call
      $projectDates = $datesCollection[0];

        $reflectedDates = new \ReflectionClass($projectDates);

        $properties = $reflectedDates->getProperties(\ReflectionProperty::IS_PROTECTED);

        $Fields = array();

        foreach ($properties as $property) {
            $result = $projectDates->getDateChanged($property->name);

            if (true === $result) {
                $Fields[] = $property->name;
            }
        }

        $gridQueryBuilder = $this->container->get('thrace_data_grid.provider')->get('dates')->getQueryBuilder();

        $queryString = $gridQueryBuilder->getQuery()->getDQL();

        $columnNames = array();

        foreach ($Fields as $field) {
            $search = 'd\.'.$field;

            $regex = '~'.$search.'\s+as\s+(\w+),'.'~';

            $match = array();

            $result = preg_match($regex, $queryString, $match);

            if ($result === 1) {
                $columnName = $match[1];

                $columnNames[] = $columnName;
            }
        }

        $data = array(
        'store_id' => $request->get('store_id'),
        'cell_color' => $request->get('cell_color'),
        'cell' => $columnNames,
      );

        $response = new JsonResponse();

        $response->setData($data);

        return $response;
    }

    public function array_random($arr, $num = 1)
    {
        shuffle($arr);

        $r = array();
        for ($i = 0; $i < $num; $i++) {
            $r[] = $arr[$i];
        }

        return $num == 1 ? $r[0] : $r;
    }
}
