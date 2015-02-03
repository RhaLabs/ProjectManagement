<?php

namespace Rha\RevitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
/**
 * Revitui controller.
 *
 * @Route("/icons")
 */
class IconsController extends Controller
{
    /**
     * @Route("/", name="rha_revit_icons")
     * @Template()
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->render('RhaRevitBundle:Icons:icons.html.twig');
    }
}
