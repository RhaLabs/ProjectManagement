<?php

namespace LimeTrail\IndexBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('LimeTrailIndexBundle:Default:index.html.twig');
    }

    public function privacyAction()
    {
        return $this->render('LimeTrailIndexBundle:Default:privacy.html.twig');
    }

    public function policyAction($policy)
    {
        $template = '';
        if ($policy == 'content') {
            $template = 'LimeTrailIndexBundle:Default:policy.content.twig';
        } elseif ($policy == 'privacy') {
            $template =  'LimeTrailIndexBundle:Default:policy.privacy.twig';
        } elseif ($policy == 'tos') {
            $template =  'LimeTrailIndexBundle:Default:policy.tos.twig';
        } elseif ($policy == 'conditions') {
            $template =  'LimeTrailIndexBundle:Default:policy.conditions.twig';
        } else {
            $template =  'LimeTrailIndexBundle:Default:policy.index.twig';
        }

        return $this->render('LimeTrailIndexBundle:Default:policy.html.twig', array('policy' => $template));
    }

    public function mAction()
    {
        return $this->render('LimeTrailBundle:Default:index.mhtml.twig');
    }
}
