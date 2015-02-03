<?php

namespace Rha\ProjectManagementBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Rha\ProjectManagementBundle\Entity\StoreInformation;
use Rha\ProjectManagementBundle\Entity\ProjectInformation;
use Rha\ProjectManagementBundle\Form\Type\ProjectInformationType;
use Rha\ProjectManagementBundle\Form\Type\StoreInformationType;

 /**
  * @Route("/project")
  * @Template()
  */
class ProjectController extends Controller
{
    /**
     * @Route("", name="rha_project")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager('rha');

        $DataGrid = $this->container->get('thrace_data_grid.provider')->get('dates');

        return array(
            'DataGrid' => $DataGrid, 'identifier' => 'rhaprojects',
      );
    }

    /**
     * @Route("/new/site", name="rha_site_new")
     * @Method("GET")
     * @Template()
     */
    public function newSiteAction()
    {
        $entity = new StoreInformation();
        $form = $this->createCreateForm($entity);

        return array(
        'entity' => $entity,
        'form' => $form->createView(),
        'identifier' => 'store_information',
      );
    }

    /**
     * @Route("/new/project", name="rha_project_new")
     * @Method("GET")
     * @Template()
     */
    public function newProjectAction()
    {
        $entity = new ProjectInformation();
        $form = $this->createCreateForm($entity);

        return array(
        'entity' => $entity,
        'form' => $form->createView(),
        'identifier' => 'project_information',
      );
    }

    private function createCreateForm($entity)
    {
        $em = $this->getDoctrine()->getManager('rha');

        switch (get_class($entity)) {
        case "Rha\ProjectManagementBundle\Entity\StoreInformation":
          $type = new StoreInformationType($em);
          $route = 'rha_store_create';
          break;
        case "Rha\ProjectManagementBundle\Entity\ProjectInformation":
          $type = new ProjectInformationType($em);
          $route = 'rha_project_create';
          break;
        default:
          break;
      }

        $form = $this->createForm($type, $entity, array(
        'action' => $this->generateUrl($route),
        'method' => 'POST',
      ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * @Route("/project/create", name="rha_project_create")
     * @Method("POST")
     * @Template()
     */
    public function createProjectAction(Request $request)
    {
        $entity = new ProjectInformation();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager('rha');

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('rha_project_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * @Route("/site/create", name="rha_store_create")
     * @Method("POST")
     * @Template()
     */
    public function createStoreAction(Request $request)
    {
        $entity = new StoreInformation();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager('rha');

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('rha_store_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
}
