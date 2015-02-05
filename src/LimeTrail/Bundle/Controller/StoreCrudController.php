<?php

namespace LimeTrail\Bundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use LimeTrail\Bundle\Entity\StoreInformation;
use LimeTrail\Bundle\Entity\ProjectInformation;
use LimeTrail\Bundle\Form\StoreInformationType;
use LimeTrail\Bundle\Form\Data\StoreProjectData;
use LimeTrail\Bundle\Model\StoreProjectModel;

/**
 * Contact controller.
 *
 * @Route("/storeinformation")
 */
class StoreCrudController extends Controller
{
    /**
     *
     * @Route("/select", name="storeinformation_select")
     * @Method("GET")
     * @Template()
     */
    public function selectAction()
    {
        $entity = new StoreInformation();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'identifier' => 'stores',
        );
    }
    
    /**
     * A really basic form to quickly add projects.
     * this needs to be removed and replaced with a Symfony form
     *
     * @Route("/newproject", name="storeinformation_hackform")
     * @Method({"GET","POST"})
     * @Template()
     */
    public function newformAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager('limetrail');
        
        $formData = new StoreProjectData();
        
        $builder = $this->createFormBuilder($formData);
        $builder->add('storeNumber', 'integer')
                ->add('sequenceNumber', 'integer')
                ->add('projectNumber', 'integer')
                ->add('canonicalName', 'text',
                    array(
                        'label' => 'Project Name',
                    )
                )
                ->add('state', 'text')
                ->add('city', 'text')
                ->add('storeType', 'entity', array(
                    'class' => 'LimeTrailBundle:StoreType',
                    'property' => 'name',
                ))
                ->add('projectType', 'entity', array(
                    'class' => 'LimeTrailBundle:ProjectType',
                    'property' => 'name',
                ))
                ->add('projectPhase','integer')
                ->add('confidential', 'choice', 
                    array(
                        'choice_list' => new ChoiceList(array(true, false), array('Yes', 'No')),
                        'multiple'  => false,
                        'expanded'  => true,
                    )
                )
                ->add('combo', 'choice', 
                    array(
                        'choice_list' => new ChoiceList(array(true, false), array('Yes', 'No')),
                        'multiple'  => false,
                        'expanded'  => true,
                    )
                )
                ->add('manageSitesDifferently', 'choice', 
                    array(
                        'choice_list' => new ChoiceList(array(true, false), array('Yes', 'No')),
                        'multiple'  => false,
                        'expanded'  => true,
                    )
                )
                ->add('sap', 'text')
                ->add('storeSquareFootage','integer')
                ->add('increaseSquareFootage','integer')
                ->add('prjTotalSquareFootage','integer')
                ->add('actTotalSquareFootage','integer')
                ->add('save', 'submit', array('label' => 'Create Store'));

        $form = $builder->getForm();
                
        
        $form->handleRequest($request);

        if ($form->isValid()) {
            $formData = $form->getData();
            $formData->user = $this->get('security.token_storage')->getToken()->getUser()->getUserName();
            
            $storeModel = new StoreProjectModel($formData, $this->get('lime_trail_store.provider'));
            
            $storeModel->ProcessFormData();
            
            $entityArray = $storeModel->getEntityResult();
            
            foreach ( $entityArray AS $entity) {
                $em->persist($entity);
            }
            $em->flush();
            
            $store = $entityArray['store'];
            
            $request->getSession()->getFlashBag()->add(
                'notice',
                'Your changes were saved!'
            );

            return $this->redirect($this->generateUrl('storeinformation_hackform'));
        }

        return array(
            'entity' => $formData,
            'form'   => $form->createView(),
        );
    }
    

    /**
     * Creates a new StoreInformation entity.
     *
     * @Route("/", name="storeinformation_create")
     * @Method("POST")
     * @Template("LimeTrailBundle:StoreCrud:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new StoreInformation();
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

            return $this->redirect($this->generateUrl('storeinformation_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a StoreInformation entity.
    *
    * @param Contact $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(StoreInformation $entity)
    {
        $form = $this->createForm(new StoreInformationType(), $entity, array(
            'action' => $this->generateUrl('storeinformation_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new StoreInformation entity.
     *
     * @Route("/new", name="storeinformation_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new StoreInformation();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'identifier' => 'stores',
        );
    }

    /**
     * Finds and displays a StoreInformation entity.
     *
     * @Route("/{id}", name="storeinformation_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager('limetrail');

        $entity = $em->getRepository('LimeTrailBundle:StoreInformation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StoreInformation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing StoreInformation entity.
     *
     * @Route("/edit/{id}", name="storeinformation_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager('limetrail');

        $entity = $em->getRepository('LimeTrailBundle:StoreInformation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StoreInformation entity.');
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
    * Creates a form to edit a StoreInformation entity.
    *
    * @param Contact $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(StoreInformation $entity)
    {
        $form = $this->createForm(new StoreInformationType(), $entity, array(
            'action' => $this->generateUrl('storeinformation_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Contact entity.
     *
     * @Route("/{id}", name="storeinformation_update")
     * @Method("PUT")
     * @Template("LimeTrailBundle:StoreCrud:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager('limetrail');

        $entity = $em->getRepository('LimeTrailBundle:StoreInformation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find StoreInformation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('storeinformation_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a StoreInformation entity.
     *
     * @Route("/{id}", name="storeinformation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager('limetrail');
            $entity = $em->getRepository('LimeTrailBundle:StoreInformation')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find StoreInformation entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('limetrail_storeinformation'));
    }

    /**
     * Creates a form to delete a StoreInformation entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('storeinformation_delete', array('id' => $id)))
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
