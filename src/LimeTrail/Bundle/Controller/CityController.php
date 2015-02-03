<?php

namespace LimeTrail\Bundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use LimeTrail\Bundle\Entity\City;
use LimeTrail\Bundle\Form\CityType;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\NoResultException;

/**
 * City controller.
 *
 * @Route("/feature")
 */
class CityController extends Controller
{
    /**
     * Lists all City entities.
     *
     * @Route("/", name="cities")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager('limetrail');

        $entities = $em->getRepository('LimeTrailBundle:City')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Lists all City entities.
     * http://stackoverflow.com/questions/2953110/return-json-to-ajax-in-symfony
     https://github.com/FriendsOfSymfony/FOSRestBundle/blob/master/Resources/doc/index.md
     * @Route("/getcities/{state}", name="city")
     * @Method({"GET", "POST"})
     * @Template("LimeTrailBundle:City:cityselect.html.twig")
     */
    public function cityAction($state)
    {
        $em = $this->getDoctrine()->getManager('limetrail');

        $State = $this->getState($em, $state);
        $Cities = $State->getCities();

        $entities = array();
        foreach ($Cities as $key => $c) {
            $entities[] = array('id' => $c->getId(),
                              'city' => $c->getName(), );
          //$id[$key] = $c->getId();
          $city[$key] = $c->getName();
        }
        //natcasesort($entities);

        array_multisort($city, SORT_ASC, $entities);
        //$response = new JsonResponse();
        //$response->setData(array('data'=>$entities));
        //return $response;
        return array('data' => $entities);
    }

    /**
     * Lists all City entities.
     *
     * Route("/{city}/{state}", name="citystate")
     * Method("GET")
     * Template("LimeTrailBundle:City:new.html.twig")
     */
    public function citystateAction($city, $state)
    {
        $em = $this->getDoctrine()->getManager('limetrail');

        $State = $this->getState($em, $state);
        $City = $this->getCityFromState($city, $State);

        return array(
            'entities' => $City,
        );
    }

    /**
     * Lists all City entities.
     *
     * @Route("/cityurl", name="cityurl")
     * @Method("GET")
     * @Template("LimeTrailBundle:City:cityurl.html.twig")
     */
    public function cityurlAction(Request $request)
    {
        $storeid = $request->query->get('id');
        $em = $this->getDoctrine()->getManager('limetrail');
        $store = $em->getRepository('LimeTrailBundle:StoreInformation')->find($storeid);
        $entity = $store->getCity();

        return array(
            'url' => $entity->getUrl(),
        );
    }

    /**
     * Creates a new City entity.
     *
     * @Route("/", name="city_create")
     * @Method("GET")
     * @Template("LimeTrailBundle:City:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new City();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('city_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a City entity.
    *
    * @param City $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(City $entity)
    {
        $form = $this->createForm(new CityType(), $entity, array(
            'action' => $this->generateUrl('city_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new City entity.
     *
     * @Route("/new", name="city_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new City();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a City entity.
     *
     * @Route("/{id}", name="city_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LimeTrailBundle:City')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find City entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing City entity.
     *
     * @Route("/{id}/edit", name="city_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LimeTrailBundle:City')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find City entity.');
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
    * Creates a form to edit a City entity.
    *
    * @param City $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(City $entity)
    {
        $form = $this->createForm(new CityType(), $entity, array(
            'action' => $this->generateUrl('city_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing City entity.
     *
     * @Route("/{id}", name="city_update")
     * @Method("PUT")
     * @Template("LimeTrailBundle:City:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LimeTrailBundle:City')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find City entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('city_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a City entity.
     *
     * @Route("/{id}", name="city_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LimeTrailBundle:City')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find City entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('city'));
    }

    /**
     * Creates a form to delete a City entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('city_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    private function getCityFromState($qcity, $state)
    {
        if (!$qcity) {
            return;
        }
        $city = $this->ucname(html_entity_decode(preg_replace('/[^\x2D\x41-\x7A\s]*(\x2C.*|\(.*)/ui', '', $qcity), ENT_NOQUOTES, 'UTF-8'));

        $city = preg_replace('/^(st\x2E{0,1}\b)/iu', 'Saint', $city);
        $city = preg_replace('/^(ft\x2E{0,1}\b)/i', 'Fort', $city);

        $cities = $state->getCities();
        $thisCity = $this->findInResult($cities, trim(preg_replace('/\x{00a0}/siu', '', $city)));
        if (!$thisCity || $thisCity->isEmpty()) {
            return;
        }
        $c = $thisCity->first();

        return $c;
    }
    public function ucname($string)
    {
        $string = ucwords(strtolower($string));

        foreach (array('-', '\'', 'Mc') as $delimiter) {
            if (strpos($string, $delimiter) !== false) {
                $string = implode($delimiter, array_map('ucfirst', explode($delimiter, $string)));
            }
        }

        return $string;
    }
  // @var $state must be a string
  private function getState($em, $state)
  {
      $q = $em->getRepository('LimeTrailBundle:State');
      try {
          if (strlen($state) == 2) {
              $t = $q->findOneByAbbreviation($state);
              if (!$t) {
                  throw new NoResultException();
              }// echo get_class($t)."\n";

       return $t;
          } else {
              $t = $q->findOneByName($state);
              if (!$t) {
                  throw new NoResultException();
              }// echo get_class($t)."\n";

       return $t;
          }
      } catch (\Doctrine\ORM\NoResultException $e) {
          // echo "null state\n";

      return;
      }
  }
    private function findInResult($array, $name)
    {
        if ($array->isEmpty()) {
            return;
        }
    /*$array->filter(
      function ($a) use ($name) {
        return in_array($array->getName(), $name);
      }
    );*/
    //$name = '%'.$name.'%';
    $criteria = Criteria::create()->where(Criteria::expr()->eq("name", $name))
                                  ->orderBy(array("name" => Criteria::ASC))
                                  ->setFirstResult(0);
        $result = $array->matching($criteria);//var_dump($result);

    return $result;
    }
}
