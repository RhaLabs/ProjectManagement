<?php

namespace Rha\ProjectManagementBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Rha\ProjectManagementBundle\Entity\ProjectCriteria;
use Rha\ProjectManagementBundle\Form\Type\ProjectCriteriaType;

 /**
  * @Route("/financial")
  * @Template()
  */
class FinancialController extends Controller
{
    /**
     * @Route("/", name="rha_financial_home")
     * @Template()
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager('rha');

        $allContracts = $em->getRepository('RhaProjectManagementBundle:ProjectCriteria')->findAll();

        return array( 'contracts' => $allContracts);
    }

    /**
     * Displays a form to create a new entity.
     *
     * @Route("/new", name="rha_financial_contract_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ProjectCriteria();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'identifier' => 'projectCriteria',
        );
    }

    /**
     * Creates a new entity.
     *
     * @Route("/", name="rha_financial_contract_create")
     * @Method("POST")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $entity = new ProjectCriteria();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager('rha');

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('trail_contact_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

   /**
    * Creates a form to create an entity.
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(ProjectCriteria $entity)
    {
        $em = $this->getDoctrine()->getManager('rha');

        $form = $this->createForm(new ProjectCriteriaType($em), $entity, array(
            'action' => $this->generateUrl('rha_financial_contract_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }
}
