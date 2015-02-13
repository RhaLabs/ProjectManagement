<?php

namespace LimeTrail\Bundle\Controller;

use APY\DataGridBundle\Grid\Source\Entity;
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
         * @Method({"GET", "POST"})
         * @Template()
         */
        public function projectAction($id)
        {
            $source = new Entity('LimeTrailBundle:ProjectChangeInitiation', 'changeInitiation', 'limetrail');

            // Get a grid instance
            $grid = $this->get('grid');

            //manipulate query to reutn only the store projects we want
            $tableAlias = $source->getTableAlias();

            $source->manipulateQuery(
                function ($qb) use ($tableAlias, $id) {
                    $qb->andWhere('_project.id = :pid')->setParameter('pid', $id);
                }
            );

            // Set the source
            $grid->setSource($source);

            $grid->setColumnsOrder(
                array(
                    'change.number',
                    'change.title',
                    'change.releaseDate',
                    'accepted',
                    'dateImplemented',
                    'dateAssigned',
                ),
                true
            );

            // Set the selector of the number of items per page
            $grid->setLimits(array(30, 60, 80, 120));

            // Set the default page
            $grid->setDefaultPage(1);

            return $grid->getGridResponse();
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
