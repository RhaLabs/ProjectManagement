<?php

namespace LimeTrail\Bundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use LimeTrail\Bundle\Entity\ProjectContacts;
use LimeTrail\Bundle\Entity\Contact;
use LimeTrail\Bundle\Entity\Company;
/**
 * StoreInformation controller.
 *
 * @Route("/change")
 */
class ProjectChangeController extends Controller
{
    /**
     *
     * @Route("/", name="project_change")
     * @Method("GET")
     * @Template()
     */
    public function changeAction()
    {
        
        return $this->render('LimeTrailBundle:Contacts:index.html.twig', array(
            'DataGrid' => $DataGrid, 'identifier' => $alias,
            ));
    }

    /**
     *
     * @Route("/get/{number}", name="get_change")
     * @Method("GET")
     * @Template()
     */
    public function indexAction($number)
    {
        $em = $this->getDoctrine()->getManager('limetrail');

        $change = $em->getRepository('LimeTrailBundle:ChangeInitiation')
                     ->findOneBy(array('number' => $number));
        
        $change->getScopes();
        
        return array('change' => $change);
    }

    /**
     *
     *
     * @Route("/project/{id}", name="limetrail_project_change_get")
     * @Method("GET")
     * @Template()
     */
        public function projectAction($id)
        {
            $em = $this->getDoctrine()->getManager('limetrail');

            $alias = 'project_change';

            $DataGrid = $this->container->get('thrace_data_grid.provider')->get($alias);

            $session = $this->container->get('request')->getSession();

            $session->set('lime_trail_project_change/id', $id);

            return $this->render('LimeTrailBundle:Contacts:index.html.twig', array(
            'DataGrid' => $DataGrid, 'identifier' => $alias,
            ));
        }

    /**
     *
     * @Route("/create", name="limetrail_contacts_create")
     * @Method("GET")
     * @Template()
     */
    public function createContactAction(Request $request)
    {
        $referer = $request->headers->get('referer');

        $contactprovider = $this->container->get('lime_trail_contact.provider');

      //$projectcontact = new ProjectContacts();
    }

    /**
     * @Route("/add", name="limetrail_contacts_add")
     * @Method("GET")
     * @Template()
     */
    public function addContactAction(Request $request)
    {
        $referer = $request->headers->get('referer');

        $contactprovider = $this->container->get('lime_trail_contact.provider');

        $companyprovider = $this->container->get('lime_trail_company.provider');
        $companies = $companyprovider->getAllCompanies();

        $companyArray = array();
        foreach ($companies as $company) {
            $companyArray[$company->getId()] = $company->getName();
        }

        $contact = new Contact();
        $contact->setFirstName('');
        $contact->setLastName('');

        $form = $this->createFormBuilder($contact)
                   ->add('Company', 'choice',
                    array('choices' => $companyArray,
                    'mapped' => false,
                    'empty_value' => 'Select a Company',
                    )
                   )
                   ->add('firstName', 'text')
                   ->add('lastName', 'text')
                   ->add('save', 'submit')
                   ->getForm();

        return $this->render('LimeTrailBundle:Contacts:addContact.html.twig', array('form' => $form->createView()));
    }
}
