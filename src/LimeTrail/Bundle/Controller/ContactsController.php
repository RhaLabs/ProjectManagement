<?php

namespace LimeTrail\Bundle\Controller;

use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use LimeTrail\Bundle\Entity\ProjectContacts;
use LimeTrail\Bundle\Entity\Contact;
use LimeTrail\Bundle\Entity\JobRole;
use LimeTrail\Bundle\Entity\Company;
/**
 * StoreInformation controller.
 *
 * @Route("/contacts")
 */
class ContactsController extends Controller
{
    /**
     * Lists all Contacts entities.
     *
     * @Route("/", name="limetrail_contacts")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager('limetrail');

        $alias = 'contacts';

        /** @var \Thrace\DataGridBundle\DataGrid\DataGridInterface */
        $ContactsDataGrid = $this->container->get('thrace_data_grid.provider')->get($alias);

        return $this->render('LimeTrailBundle:Contacts:index.html.twig', array(
            'ContactsDataGrid' => $ContactsDataGrid,
            'identifier' => 'contacts',
        ));
    }

    /**
     *
     * Retrieves contacts for a store
     *
     * @Route("/project/{id}", name="limetrail_contacts_get")
     * @Method("GET")
     * @Template()
     */
    public function projectAction($id)
    {
            /*$em = $this->getDoctrine()->getManager('limetrail');

            $alias = 'projects_contact';

            $ConactsDataGrid = $this->container->get('thrace_data_grid.provider')->get($alias);

            $session = $this->container->get('request')->getSession();

            $session->set('contactId', $id);

            return $this->render('LimeTrailBundle:Contacts:index.html.twig', array(
            'ProjectInfoDataGrid' => $ConactsDataGrid, 'identifier' => $alias,
            ));*/
            
        $source = new Entity('LimeTrailBundle:ProjectContacts', 'project_contacts', 'limetrail');
        
        // Get a grid instance
        $grid = $this->get('grid');
        
        //manipulate query to reutn only the store projects we want
        $tableAlias = $source->getTableAlias();
        
        $source->manipulateQuery(
            function ($query) use ($tableAlias, $id)
            {
                $query->andWhere("_project.id = :pid")->setParameter('pid', $id);
            }
        );

        // Set the source
        $grid->setSource($source);

        // Set the selector of the number of items per page
        $grid->setLimits(array(30));

        // Set the default page
        $grid->setDefaultPage(1);
        
        //grid actions
        $rowAction = new RowAction(
            'Edit',
            "limetrail_projectcontacts_edit");
        $rowAction->setRouteParameters(
            array(
                'id',
                'jobrole.id',
            )
        );
        
        $grid->addRowAction($rowAction);
        
        return $grid->getGridResponse();
    }
    
    /**
     *
     * Edit contacts for a store
     *
     * @Route("/project/edit/{id}/{jobroleId}", name="limetrail_projectcontacts_edit")
     * @Method("POST")
     * @Template()
     */
    public function projectContactEditAction($id, $jobroleId)
    {
        //TODO build SF2 form
        $contactprovider = $this->get('lime_trail_contact.provider');
        
        $jobrole = $contactprovider->findJobRoleById($jobRoleId);
        $projectcontact = $contactprovider->findProjectContactById($projectContactId);
        $contact = $projectcontact->getContact();
        
        
        
        $this->get('validator')->validate($contact);
        
        $em = $this->get('doctrine')->getManager('limetrail');
        
        $em->persist($projectcontact);
        $em->persist($contact);
        $em->flush();
    }

    /**
     * Lists all Job Roles
     * @Route("/getroles", name="fetch_job_roles")
     * @Method({"GET", "POST"})
     * @Template("LimeTrailBundle:Contacts:select.html.twig")
     */
    public function jobroleAction()
    {
        $jobroles = $this->container->get('lime_trail_contact.provider')->findAllJobRoles();

        $entities = array();

        foreach ($jobroles as $key => $v) {
            $entities[] = array('id' => $v->getId(),
                              'name' => $v->getJobRole(), );

            $role[$key] = $v->getJobRole();
        }

        array_multisort($role, SORT_ASC, $entities);

        return array('data' => $entities);
    }

    /**
     * @Route("/getcontacts", name="fetch_contacts")
     * @Method({"GET", "POST"})
     * @Template("LimeTrailBundle:Contacts:select.html.twig")
     */
    public function contactsAction()
    {
        $contacts = $this->container->get('lime_trail_contact.provider')->findAllContacts();

        $entities = array();

        $concat = function ($v) { return $v->getLastName().', '.$v->getFirstName(); };

        foreach ($contacts as $key => $v) {
            $entities[] = array('id' => $v->getId(),
                              'name' => $concat($v),
                             );

            $role[$key] = $concat($v);
        }

        array_multisort($role, SORT_ASC, $entities);

        return array('data' => $entities);
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
