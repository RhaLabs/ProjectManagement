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

            return $this->redirect($this->generateUrl('storeinformation_show', array('id' => $store->getId())));
        }

        return array(
            'entity' => $formData,
            'form'   => $form->createView(),
        );
    }

}
