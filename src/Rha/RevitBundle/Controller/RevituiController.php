<?php

namespace Rha\RevitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
/**
 * Revitui controller.
 *
 * @Route("/revitui")
 */
class RevituiController extends Controller
{
    /**
     * @Route("/", name="rha_revit_revitui")
     * @Template()
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->render('RhaRevitBundle:Revitui:revitui.html.twig');
    }

    /**
     * @Route("/Annotate", name="rha_revit_revitui_annotate")
     * @Template()
     * @Method("GET")
     */
    public function annotateAction()
    {
        return $this->render('RhaRevitBundle:Revitui\\revitui:Annotate.html.twig');
    }
    /**
     * @Route("/Add-ins", name="rha_revit_revitui_addin")
     * @Template()
     * @Method("GET")
     */
    public function addinAction()
    {
        return $this->render('RhaRevitBundle:Revitui\\revitui:Add-Ins.html.twig');
    }
    /**
     * @Route("/Architecture", name="rha_revit_revitui_architecture")
     * @Template()
     * @Method("GET")
     */
    public function architectureAction()
    {
        return $this->render('RhaRevitBundle:Revitui\\revitui:architecture.html.twig');
    }
    /**
     * @Route("/Collaborate", name="rha_revit_revitui_collaborate")
     * @Template()
     * @Method("GET")
     */
    public function collaborateAction()
    {
        return $this->render('RhaRevitBundle:Revitui\\revitui:Collaborate.html.twig');
    }
    /**
     * @Route("/Insert", name="rha_revit_revitui_insert")
     * @Template()
     * @Method("GET")
     */
    public function insertAction()
    {
        return $this->render('RhaRevitBundle:Revitui\\revitui:Insert.html.twig');
    }
    /**
     * @Route("/Manage", name="rha_revit_revitui_manage")
     * @Template()
     * @Method("GET")
     */
    public function manageAction()
    {
        return $this->render('RhaRevitBundle:Revitui\\revitui:Manage.html.twig');
    }
    /**
     * @Route("/Modify", name="rha_revit_revitui_modify")
     * @Template()
     * @Method("GET")
     */
    public function modifyAction()
    {
        return $this->render('RhaRevitBundle:Revitui\\revitui:Modify.html.twig');
    }
    /**
     * @Route("/View", name="rha_revit_revitui_view")
     * @Template()
     * @Method("GET")
     */
    public function viewAction()
    {
        return $this->render('RhaRevitBundle:Revitui\\revitui:View.html.twig');
    }
}
