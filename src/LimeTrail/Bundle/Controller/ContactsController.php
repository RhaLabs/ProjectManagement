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
use LimeTrail\Bundle\Exporter\CsvExporter;
use LimeTrail\Bundle\Model\ProjectContactModel;
use LimeTrail\Bundle\Form\Data\ProjectContactData;
use LimeTrail\Bundle\Form\Data\NewProjectContactData;

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
        $source = new Entity('LimeTrailBundle:ProjectContacts', 'project_contacts', 'limetrail');

        // Get a grid instance
        $grid = $this->get('grid');

        //manipulate query to reutn only the store projects we want
        $tableAlias = $source->getTableAlias();

        $source->manipulateQuery(
            function ($query) use ($tableAlias, $id) {
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
        $editAction = new RowAction(
            'Edit',
            "limetrail_projectcontacts_edit",
            false,
            '_self',
            array('class' => 'btn btn-sm btn-default')
        );
        $editAction->setRouteParameters(
            array(
                'id',
                'jobrole.id',
                'project.id',
            )
        );

        $grid->addRowAction($editAction);

        $deleteAction = new RowAction(
            'Delete',
            'limetrail_projectcontacts_delete',
            true,
            '_self',
            array('class' => 'btn btn-sm btn-danger'),
            'ROLE_ADMIN'
        );
        $deleteAction->setRouteParameters(
            array(
                'id',
                'project.id',
            )
        );

        $grid->addRowAction($deleteAction);
        
        // Enable csv export
        $grid->addExport(new CsvExporter('CSV Export', 'export'));

        $gridResponse = $grid->getGridResponse();

        return array(
            'data' => $gridResponse,
            'projectId' => $id,
            );
    }

    /**
     *
     * Edit contacts for a store
     *
     * @Route("/project/edit/{id}/{jobroleId}", name="limetrail_projectcontacts_edit")
     * @Method({"GET","POST"})
     * @Template()
     */
    public function projectContactEditAction($id, $jobroleId, Request $request)
    {
        $em = $this->getDoctrine()->getManager('limetrail');

        $contactprovider = $this->get('lime_trail_contact.provider');

        $jobrole = $contactprovider->findJobRoleById($jobroleId);
        $projectcontact = $contactprovider->findProjectContactById($id);
        $contact = $projectcontact->getContact();

        $formData = new ProjectContactData($contact, $jobrole, $projectcontact);

        $builder = $this->createFormBuilder($formData);
        $builder->add('firstName', 'text')
                ->add('middleName', 'text', array('required' => false))
                ->add('lastName', 'text')
                ->add('jobTitle', 'text', array('required' => false))
                ->add('jobRole', 'entity', array(
                    'class' => 'LimeTrailBundle:JobRole',
                    'property' => 'jobRole',
                ))
                ->add('directPhone', 'text', array('required' => false))
                ->add('mobilePhone', 'text', array('required' => false))
                ->add('email', 'email')
                ->add('website', 'text', array('required' => false))
                ->add('chartColor', 'text', array('required' => false))
                ->add('save', 'submit', array('label' => 'Save Contact'));

        $form = $builder->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $formData = $form->getData();

            $projectContactModel = new ProjectContactModel($formData, $contactprovider);

            $projectContactModel->ProcessFormData();

            $entityArray = $projectContactModel->getEntityResult();

            foreach ($entityArray as $entity) {
                $em->persist($entity);
            }

            $em->flush();

            $request->getSession()->getFlashBag()->add(
                'notice',
                'Your changes were saved!'
            );

            return $this->redirect($this->generateUrl('limetrail_contacts_get', array('id' => $request->get('projectId'))));
        }

        return array(
            'entity' => $formData,
            'form'   => $form->createView(),
        );
    }

    /**
     *
     * Adds contacts for a store
     *
     * @Route("/project/add/{id}", name="limetrail_projectcontacts_add")
     * @Method({"GET","POST"})
     * @Template()
     */
    public function projectContactAddAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager('limetrail');

        $entity = $em->getRepository('LimeTrailBundle:ProjectInformation')->find($id);

        $formData = new NewProjectContactData($entity);

        $builder = $this->createFormBuilder($formData);
        $builder->add('contact', 'entity', array(
                    'class' => 'LimeTrailBundle:Contact',
                    'query_builder' => function ($repo) {
                        $qb = $repo->createQueryBuilder('c');
                        $qb->select('c')
                           ->orderBy('c.lastName', 'ASC');

                        return $qb;
                    },
                ))
                ->add('jobRole', 'entity', array(
                    'class' => 'LimeTrailBundle:JobRole',
                    'property' => 'jobRole',
                ))
                ->add('save', 'submit', array('label' => 'Save Contact'));

        $form = $builder->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $formData = $form->getData();

            $provider = $this->container->get('lime_trail_contact.provider');

            $projectContact = $provider->createProjectContact($formData->project, $formData->jobRole, $formData->contact);

            $em->flush();

            $request->getSession()->getFlashBag()->add(
                'notice',
                'Your changes were saved!'
            );

            return $this->redirect($this->generateUrl('limetrail_contacts_get', array('id' => $id)));
        }

        return array(
            'entity' => $formData,
            'form'   => $form->createView(),
        );
    }

    /**
     *
     * Deletes contacts for a store
     *
     * @Route("/project/delete/{id}/{projectId}", name="limetrail_projectcontacts_delete")
     * @Method({"GET","POST"})
     * @Template()
     */
    public function projectContactDeleteAction($id, $projectId, Request $request)
    {
        $provider = $this->container->get('lime_trail_contact.provider');

        $projectcontact = $provider->findProjectContactById($id);

        $provider->deleteProjectContact($projectcontact);

        $this->getDoctrine()->getManager('limetrail')->flush();

        $request->getSession()->getFlashBag()->add(
            'notice',
            'Your changes were saved!'
        );

        return $this->redirect($this->generateUrl('limetrail_contacts_get', array('id' => $projectId)));
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
