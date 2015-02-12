<?php

namespace LimeTrail\Bundle\Controller;

use APY\DataGridBundle\Grid\Source\Entity;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * StoreInformation controller.
 *
 * @Route("/tenants")
 */
class TenantController extends Controller
{
    /**
     *
     * @Route("/get/{number}", name="get_change")
     * @Method("GET")
     * @Template()
     */
    public function indexAction($number)
    {
        $em = $this->getDoctrine()->getManager('limetrail');

        $entity = $em->getRepository('LimeTrailBundle:Tenant')
                     ->findOneBy(array('id' => $number));
        
        return array('tenant' => $entity);
    }

    /**
     *
     *
     * @Route("/project/{id}", name="limetrail_tenants_get")
     * @Method({"GET", "POST"})
     * @Template()
     */
        public function projectAction($id)
        {
            $source = new Entity('LimeTrailBundle:Tenant', 'tenants', 'limetrail');
        
            // Get a grid instance
            $grid = $this->get('grid');
            
            //manipulate query to reutn only the store projects we want
            $tableAlias = $source->getTableAlias();
            
            $source->manipulateQuery(
                function ($qb) use ($tableAlias, $id)
                {
                    $qb->andWhere('_project.id = :pid')->setParameter('pid', $id);
                }
            );
    
            // Set the source
            $grid->setSource($source);
            
            /*$grid->setColumnsOrder(
                array(
                    'change.number',
                    'change.title',
                    'change.releaseDate',
                    'accepted',
                    'dateImplemented',
                    'dateAssigned',
                ),
                true
            );*/
    
            // Set the selector of the number of items per page
            $grid->setLimits(array(30,60,80,120));
    
            // Set the default page
            $grid->setDefaultPage(1);
            
            return $grid->getGridResponse();
        }

}
