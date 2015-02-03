<?php

namespace Rha\RevitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
/*
 * @Route("/demoplan")
 */
class DemoplanController extends Controller
{
    /**
     * @Route("/", name="rha_revit_demoplan")
     * @Template()
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->render('RhaRevitBundle:Demoplan:demoplans.html.twig');
    }
}
