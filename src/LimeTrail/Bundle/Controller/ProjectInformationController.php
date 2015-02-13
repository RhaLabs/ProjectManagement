<?php

namespace LimeTrail\Bundle\Controller;

use APY\DataGridBundle\Grid\Source\Entity;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use LimeTrail\Bundle\Entity\ProjectInformation;
use LimeTrail\Bundle\Form\Type\ProjectInformationType;

/**
 * ProjectInformation controller.
 *
 * @Route("/projectinformation")
 */
class ProjectInformationController extends Controller
{
    /**
     * Creates a new ProjectInformation entity.
     *
     * @Route("/", name="limetrail_projectinformation_create")
     * @Method("POST")
     * @Template("LimeTrailBundle:ProjectInformation:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new ProjectInformation();
        $form = $this->createForm(new ProjectInformationType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('projectinformation_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new ProjectInformation entity.
     *
     * @Route("/new", name="limetrail_projectinformation_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ProjectInformation();
        $form   = $this->createForm(new ProjectInformationType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a ProjectInformation entity.
     *
     * @Route("/{id}", name="limetrail_projectinformation_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager('limetrail');
        
        $source = new Entity('LimeTrailBundle:StoreInformation', 'project_information', 'limetrail');
        
        // Get a grid instance
        $grid = $this->get('grid');
        
        //manipulate query to reutn only the store projects we want
        $tableAlias = $source->getTableAlias();
        
        $source->manipulateQuery(
            function ($query) use ($tableAlias, $id)
            {
                $query->andWhere("$tableAlias.storeNumber = :num")
                      ->setParameter(':num', $id);
            }
        );

        // Set the source
        $grid->setSource($source);

        // Set the selector of the number of items per page
        $grid->setLimits(array(5));

        // Set the default page
        $grid->setDefaultPage(1);
        
        return $grid->getGridResponse();
    }

    /**
     * Displays a form to edit an existing ProjectInformation entity.
     *
     * @Route("/{id}/edit", name="limetrail_projectinformation_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager('limetrail');

        $entity = $em->getRepository('LimeTrailBundle:ProjectInformation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProjectInformation entity.');
        }

        $editForm = $this->createForm(new ProjectInformationType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing ProjectInformation entity.
     *
     * @Route("/{id}", name="projectinformation_update")
     * @Method("PUT")
     * @Template("LimeTrailBundle:ProjectInformation:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager('limetrail');

        $entity = $em->getRepository('LimeTrailBundle:ProjectInformation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProjectInformation entity.');
        }

        $editForm = $this->createForm(new ProjectInformationType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('limetrail_projectdates_aggregated'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }
    /**
     * Deletes a ProjectInformation entity.
     *
     * @Route("/{id}", name="limetrail_projectinformation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LimeTrailBundle:ProjectInformation')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ProjectInformation entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('projectinformation'));
    }

    /**
     * Creates a form to delete a ProjectInformation entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
