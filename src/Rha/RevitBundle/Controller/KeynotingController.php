<?php

namespace Rha\RevitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
/**
 * Keynoting controller.
 *
 *
 */
class KeynotingController extends Controller
{
    /**
     * @Route("/keynoting", name="rha_revit_keynoting")
     * @Template()
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->render('RhaRevitBundle:Keynoting:Keynoting.html.twig');
    }
}
