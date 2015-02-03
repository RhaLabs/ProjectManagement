<?php

namespace LimeTrail\Bundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use LimeTrail\Bundle\Entity\Contact;
use LimeTrail\Bundle\Form\Type\ContactType;

/**
 * Contact controller.
 *
 * @Route("/contact")
 */
class ContactController extends Controller
{
    /**
     *
     * @Route("/select", name="trail_contact_select")
     * @Method("GET")
     * @Template("LimeTrailBundle:Contact:select.html.twig")
     */
    public function selectAction()
    {
        $entity = new Contact();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'identifier' => 'contacts',
        );
    }

    /**
     * Lists all Contact entities.
     *
     * @Route("/", name="trail_contact")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        /*$entities = $this->container->get('lime_trail_contact.provider')->findAllContacts();

        return array(
            'entities' => $entities,
        );*/
        $em = $this->getDoctrine()->getManager('limetrail');

        $alias = 'contacts';

        /** @var \Thrace\DataGridBundle\DataGrid\DataGridInterface */
        $ContactsDataGrid = $this->container->get('thrace_data_grid.provider')->get($alias);

        /*$colModel = $ContactsDataGrid->getColModel();

        foreach ($colModel as &$column) {
          if ($column['name'] == 'City') {
            unset($column['editable']);
            unset($column['edittype']);
            unset($column['editrules']);
            unset($column['editoptions']);
          }
        }

        $ContactsDataGrid->setColModel($colModel);*/

        return $this->render('LimeTrailBundle:Contact:index.html.twig', array(
            'ContactsDataGrid' => $ContactsDataGrid,
            'identifier' => 'contacts',
        ));
    }
    /**
     * Creates a new Contact entity.
     *
     * @Route("/", name="trail_contact_create")
     * @Method("POST")
     * @Template("LimeTrailBundle:Contact:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Contact();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager('limetrail');
            $entity->addOffice(
              $this->container->get('lime_trail_company.provider')->getOfficeById(
                $request->get('contact[officeAddress]', null, true)
              )
            );
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
    * Creates a form to create a Contact entity.
    *
    * @param Contact $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Contact $entity)
    {
        $form = $this->createForm(new ContactType(), $entity, array(
            'action' => $this->generateUrl('trail_contact_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Contact entity.
     *
     * @Route("/new", name="trail_contact_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Contact();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'identifier' => 'contacts',
        );
    }

    /**
     * Finds and displays a Contact entity.
     *
     * @Route("/{id}", name="trail_contact_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager('limetrail');

        $entity = $em->getRepository('LimeTrailBundle:Contact')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contact entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Contact entity.
     *
     * @Route("/edit/{id}", name="trail_contact_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager('limetrail');

        $entity = $em->getRepository('LimeTrailBundle:Contact')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contact entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Contact entity.
    *
    * @param Contact $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Contact $entity)
    {
        $form = $this->createForm(new ContactType(), $entity, array(
            'action' => $this->generateUrl('trail_contact_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Contact entity.
     *
     * @Route("/{id}", name="trail_contact_update")
     * @Method("PUT")
     * @Template("LimeTrailBundle:Contact:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager('limetrail');

        $entity = $em->getRepository('LimeTrailBundle:Contact')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Contact entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('trail_contact_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Contact entity.
     *
     * @Route("/{id}", name="trail_contact_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager('limetrail');
            $entity = $em->getRepository('LimeTrailBundle:Contact')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Contact entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('trail_contact'));
    }

    /**
     * Creates a form to delete a Contact entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('trail_contact_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    public function saveQueryAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager('limetrail');

        $securityContext = $this->get('security.context');

        $user = $securityContext->getToken()->getUser();
    }
}
