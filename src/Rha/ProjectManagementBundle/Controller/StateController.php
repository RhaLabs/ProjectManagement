<?php

namespace Rha\ProjectManagementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class StateController extends Controller
{
    /**
     * @Route("/state/{abbreviation}")
     * @Template()
     */
    public function getStateAction($abbreviation)
    {
        return array(
                // ...
            );
    }

    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return array(
                // ...
            );
    }
}
