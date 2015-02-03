<?php

namespace LimeTrail\Bundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use LimeTrail\Bundle\Entity\ProjectType;
use LimeTrail\Bundle\Form\ProjectTypeType;

/**
 * ProjectType controller.
 *
 * @Route("/projecttype")
 */
class ProjectTypeController extends Controller
{
    /**
     * Lists all ProjectType entities.
     *
     * @Route("/", name="projecttype")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LimeTrailBundle:ProjectType')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new ProjectType entity.
     *
     * @Route("/", name="projecttype_create")
     * @Method("POST")
     * @Template("LimeTrailBundle:ProjectType:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new ProjectType();
        $form = $this->createForm(new ProjectTypeType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('projecttype_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new ProjectType entity.
     *
     * @Route("/new", name="projecttype_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ProjectType();
        $form   = $this->createForm(new ProjectTypeType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a ProjectType entity.
     *
     * @Route("/{id}", name="projecttype_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LimeTrailBundle:ProjectType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProjectType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ProjectType entity.
     *
     * @Route("/{id}/edit", name="projecttype_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LimeTrailBundle:ProjectType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProjectType entity.');
        }

        $editForm = $this->createForm(new ProjectTypeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing ProjectType entity.
     *
     * @Route("/{id}", name="projecttype_update")
     * @Method("PUT")
     * @Template("LimeTrailBundle:ProjectType:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LimeTrailBundle:ProjectType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProjectType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ProjectTypeType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('projecttype_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a ProjectType entity.
     *
     * @Route("/{id}", name="projecttype_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LimeTrailBundle:ProjectType')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ProjectType entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('projecttype'));
    }

    /**
     * Creates a form to delete a ProjectType entity by id.
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
