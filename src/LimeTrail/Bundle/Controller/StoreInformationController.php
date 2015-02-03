<?php

namespace LimeTrail\Bundle\Controller;

use ReflectionClass;
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
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        /** @var \Thrace\DataGridBundle\DataGrid\DataGridInterface */
        $ProjectInfoDataGrid = $this->container->get('thrace_data_grid.provider')->get('store_info');

        return $this->render('LimeTrailBundle:StoreInformation:grid.html.twig', array(
            'ProjectInfoDataGrid' => $ProjectInfoDataGrid,  'identifier' => 'store_info',
        ));
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

        $session = $this->get('session');

      /*if ($securityContext->isGranted('ROLE_ADMIN')) {
        $ProjectInfoDataGrid = $this->container->get('thrace_data_grid.provider')->get('mystore_info');

        $ProjectInfoDataGrid->setPostData(array('id' => $id));

        return $this->render('LimeTrailBundle:StoreInformation:grid.html.twig',array(
            'ProjectInfoDataGrid' => $ProjectInfoDataGrid,  'identifier' => 'mystore_info'
        ));

      } elseif ($securityContext->isGranted('ROLE_USER')) {
        $ProjectInfoDataGrid = $this->container->get('thrace_data_grid.provider')->get('mystore_info');

        return $this->render('LimeTrailBundle:StoreInformation:grid.html.twig',array(
            'ProjectInfoDataGrid' => $ProjectInfoDataGrid,  'identifier' => 'mystore_info'
        ));
      } else {
        $url = $this->generateUrl(
         'limetrail_storeinformation'
        );

        return $this->redirect($url);
      }*/

      $ProjectInfoDataGrid = $this->container->get('thrace_data_grid.provider')->get('mystore_info');

        $ProjectInfoDataGrid->setPostData(array('email' => $email));

        return $this->render('LimeTrailBundle:StoreInformation:grid.html.twig', array(
            'DataGrid' => $ProjectInfoDataGrid,  'identifier' => 'mystore_info',
        ));
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
                  ->setParameter('n', 'Active')
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

        /** @var \Thrace\DataGridBundle\DataGrid\DataGridInterface */
        $DataGrid = $this->container->get('thrace_data_grid.provider')->get($alias);

        return $this->render('LimeTrailBundle:StoreInformation:gridbyclient.html.twig', array(
            'DataGrid' => $DataGrid, 'identifier' => $alias, 'result' => $result,
        ));
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
