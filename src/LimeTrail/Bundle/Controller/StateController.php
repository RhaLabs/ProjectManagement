<?php

namespace LimeTrail\Bundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use LimeTrail\Bundle\Entity\City;
use LimeTrail\Bundle\Provider\StateProvider;

/**
 * City controller.
 *
 * @Route("/feature")
 */
class StateController extends Controller
{
    /**
     *
     * @Route("/", name="state")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager('limetrail');

        $entities = $em->getRepository('LimeTrailBundle:State')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     *
     * @Route("/stateurl/{id}", name="stateurl")
     * @Method("GET")
     * @Template("LimeTrailBundle:State:stateurl.html.twig")
     */
    public function stateurlAction($id)
    {
        $em = $this->getDoctrine()->getManager('limetrail');
        $state = $em->getRepository('LimeTrailBundle:State')->find($id);

        return array(
            'url' => $state->getUrl(),
        );
    }
}
