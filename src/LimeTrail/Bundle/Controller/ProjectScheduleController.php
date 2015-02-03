<?php

namespace LimeTrail\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $alias = 'schedule';
        /** @var \Thrace\DataGridBundle\DataGrid\DataGridInterface */
        $DataGrid = $this->container->get('thrace_data_grid.provider')->get($alias);

        return $this->render('LimeTrailBundle:StoreInformation:grid.html.twig', array(
            'DataGrid' => $DataGrid, 'identifier' => $alias,
        ));
    }
}
