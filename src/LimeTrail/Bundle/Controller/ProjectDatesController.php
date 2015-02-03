<?php

namespace LimeTrail\Bundle\Controller;

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
     * Lists all StoreInformation entities.
     *
     * @Route("/", name="limetrail_projectdates")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager('limetrail');

        /** @var \Thrace\DataGridBundle\DataGrid\DataGridInterface */
        $ProjectInfoDataGrid = $this->container->get('thrace_data_grid.provider')->get('project_dates');

        return $this->render('LimeTrailBundle:ProjectDates:grid.html.twig', array(
            'ProjectInfoDataGrid' => $ProjectInfoDataGrid, 'identifier' => 'project_dates',
        ));
    }

    /**
     *
     * @Route("/aggregated", name="limetrail_projectdates_aggregated")
     * @Method("GET")
     * @Template()
     */
    public function aggregateDatesAction()
    {
        /** @var \Thrace\DataGridBundle\DataGrid\DataGridInterface */
        $DataGrid = $this->container->get('thrace_data_grid.provider')->get('dates');

        return $this->render('LimeTrailBundle:StoreInformation:grid.html.twig', array(
            'DataGrid' => $DataGrid, 'identifier' => 'dates',
        ));
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
        //$reflection = new \ReflectionClass($em->getClassMetadata(get_class($entity)));
        //$props = $reflection->getProperties(\ReflectionProperty::IS_PRIVATE); $logger->info(print_r($reflection->getName(), true));
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
