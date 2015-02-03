<?php

namespace Rha\RevitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
/**
 * Revitui controller.
 *
 * @Route("/revisedsheets")
 */
class RevisedsheetsController extends Controller
{
    /**
     * @Route("/", name="rha_revit_revisesheets")
     * @Template()
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->render('RhaRevitBundle:Revisedsheets:revisedsheets.html.twig');
    }
}
