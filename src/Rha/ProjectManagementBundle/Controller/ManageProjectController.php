<?php

namespace Rha\ProjectManagementBundle\Controller;

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
        $em = $this->getDoctrine()->getManager('limetrail');

        $DataGrid = $this->container->get('thrace_data_grid.provider')->get('dates');

        return $this->render('LimeTrailBundle:StoreInformation:grid.html.twig', array(
            'DataGrid' => $DataGrid, 'identifier' => 'rhaprojects',
      ));
    }
}
