<?php

namespace LimeTrail\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
/**
 * StoreInformation controller.
 *
 * @Route("/contacts")
 */
class EditContactController extends Controller
{
    /*
     *
     * @Route(service="contacts_controller_service")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager('limetrail');

        $alias = 'contacts';

        /** @var \Thrace\DataGridBundle\DataGrid\DataGridInterface */
        $ConactsDataGrid = $this->container->get('thrace_data_grid.provider')->get($alias);

        /** @var \Thrace\DataGridBundle\DataGrid\DataGridInterface */
        $ProejctsContactDataGrid = $this->container->get('thrace_data_grid.provider')->get('projects_contact');

        return $this->render('LimeTrailBundle:Contacts:index.html.twig', array(
            'ProejctsContactDataGrid' => $ProejctsContactDataGrid,
            'ConactsDataGrid' => $ConactsDataGrid,
            'identifier' => 'projects_contact',
        ));
    }
}
