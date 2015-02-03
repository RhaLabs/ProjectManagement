<?php

namespace LimeTrail\JqueryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('LimeTrailJqueryBundle:Default:index.html.twig', array('name' => $name));
    }
}
