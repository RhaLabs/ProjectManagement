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
     * @Route("/stateurl", name="stateurl")
     * @Method("GET")
     * @Template("LimeTrailBundle:State:stateurl.html.twig")
     */
    public function stateurlAction(Request $request)
    {
        $storeid = $request->query->get('id');
        $em = $this->getDoctrine()->getManager('limetrail');
        $stateprovider = $this->get('lime_trail_state.provider');
        $store = $em->getRepository('LimeTrailBundle:StoreInformation')->find($storeid);
        $entity = $store->getState();

        return array(
            'url' => $entity->getUrl(),
        );
    }
}
