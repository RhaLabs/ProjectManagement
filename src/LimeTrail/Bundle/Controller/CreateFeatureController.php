<?php

namespace LimeTrail\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CreateFeatureController extends Controller
{
    /**
     * @Route("/", name="limetrail_home")
     * @Template()
     */
    public function indexAction()
    {
        return $this->render('LimeTrailBundle:Default:index.html.twig');
    }
}
