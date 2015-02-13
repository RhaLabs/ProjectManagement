<?php

namespace LimeTrail\Bundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use LimeTrail\Bundle\Entity\Company;
use LimeTrail\Bundle\Entity\Office;
use LimeTrail\Bundle\Form\Type\CompanyFormType;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Company controller.
 *
 * @Route("/company")
 */
class CompanyController extends Controller
{
    /**
     * Lists all Contacts entities.
     *
     * @Route("/", name="limetrail_companies")
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
     * responses with a JSON
     *
     * @Route("/", name="limetrail_company")
     * @Method("POST")
     * @Template("LimeTrailBundle:Contacts:select.html.twig")
     */
    public function companyAction(Request $request)
    {
        $companies = $this->container->get('lime_trail_company.provider')
                          ->getCompanyByPartialName($this->container->get('request')->get('startsWith'));

        $entities = array();

        foreach ($companies as $key => $v) {
            $entities[] = array('label' => $v->getName(),
                              'value' => $v->getId(), );

            $role[$key] = $v->getName();
        }

        array_multisort($role, SORT_ASC, $entities);

        $response = new JsonResponse(array('data' => $entities));

        return $response;
    }

    /**
     *
     * @Route("/officebyid", name="limetrail_company_offices")
     * @Method({"GET", "POST"})
     * @Template("LimeTrailBundle:Company:select.html.twig")
     */
    public function companyOfficeAction(Request $request)
    {
        $company = $this->container->get('lime_trail_company.provider')
                          ->getCompany($this->container->get('request')->get('companyId'));

        $offices = $this->container->get('lime_trail_company.provider')
                          ->getOffices($company);

        $entities = array();

        $adress = function ($o) {
                                  $address = $o->getAddress()->getAddress();
                                  $city = $o->getCity();
                                  $cityName = isset($city) ? $city->getName() : 'null';

                                  return $address.', '.$cityName;
                                };

        foreach ($offices as $key => $v) {
            $entities[] = array('id' => $v->getId(),
                              'name' => $adress($v),
                             );

            $role[$key] = $v->getAddress();
        }

        array_multisort($role, SORT_ASC, $entities);

        return  array('data' => $entities);
    }

        /**
         *
         * Retrieves contacts for a store
         *
         * @Route("/company/{id}", name="limetrail_company_get")
         * @Method("GET")
         * @Template()
         */
        public function projectAction($id)
        {
            $em = $this->getDoctrine()->getManager('limetrail');

            $alias = 'projects_contact';

            $ConactsDataGrid = $this->container->get('thrace_data_grid.provider')->get($alias);

            $ConactsDataGrid->setPostData(array('id' => $id));

            return $this->render('LimeTrailBundle:Contacts:index.html.twig', array(
            'ProjectInfoDataGrid' => $ConactsDataGrid, 'identifier' => $alias,
        ));
        }

    /**
     *
     * @Route("/create", name="limetrail_company_create")
     * @Method("POST")
     * @Template("LimeTrailBundle:Company:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $referer = $request->headers->get('referer');

        $contactprovider = $this->container->get('lime_trail_contact.provider');

        $form = $this->createCreateForm();

        $form->handleRequest($request);

        if (true === $form->isValid()) {
            //save data
        $company = $form->getData();

            $office = $company->getOffices();
            $address = $office->getAddress();

            $em = $this->getDoctrine()->getManager('limetrail');

            $em->persist($address);
            $em->persist($office);
            $em->persist($company);

        //$em->flush();

        return $this->redirect($this->generateUrl('limetrail_company_new'));
        }

        return array(
        'form' => $form->createView(),
      );
    }

    /**
     * @Route("/new", name="limetrail_company_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $form = $this->createCreateForm();

        return array('form' => $form->createView());
    }

    private function createCreateForm()
    {
        $company = new Company();

        $office = new Office();

        $address = new \LimeTrail\Bundle\Entity\Address();

        $city = new \LimeTrail\Bundle\Entity\City();

        $state = new \LimeTrail\Bundle\Entity\State();

      //$zip = new \LimeTrail\Bundle\Entity\Zip();

      $office->addAddress($address);
        $office->addCity($city);
        $office->addState($state);
      //$office->addZip($zip);

      $company->setOffice($office);

        $em = $this->getDoctrine()->getManager('limetrail');

        $em->persist($company);
        $em->persist($office);
        $em->persist($address);
        $em->persist($city);
        $em->persist($state);

        $form = $this->createForm(new CompanyFormType(), $company, array(
        'action' => $this->generateUrl('limetrail_company_create'),
        'method' => 'POST',
      ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * @Route("/add", name="limetrail_company_add")
     * @Method("GET")
     * @Template()
     */
    public function addContactAction(Request $request)
    {
        $referer = $request->headers->get('referer');

        $companyprovider = $this->container->get('lime_trail_company.provider');

        $company = new Company();
        $company->setName('');

        $office = new Office();
        $office->setAddress('');

        $company->addOffice($office);

        $form = $this->createFormBuilder($company)
                   ->add('Company', 'office')
                   ->add('Name', 'text')
                   ->add('Office', 'text')
                   ->add('save', 'submit')
                   ->getForm();

        return $this->render('LimeTrailBundle:Contacts:addContact.html.twig', array('form' => $form->createView()));
    }
}
