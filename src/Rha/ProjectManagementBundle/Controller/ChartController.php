<?php

namespace Rha\ProjectManagementBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/manage")
 * @Template()
 */
class ChartController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return array('name' => 'links');
    }

    /**
     * @Route("/work_load", name="rha_pm_load")
     * @Template()
     */
    public function workLoadAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager('limetrail');

      //$logger = $this->container->get('logger');

      $qb = $em->getRepository('LimeTrailBundle:StoreInformation')->createQueryBuilder('si');

        $date = new \DateTime(date('Y-m-d'));
        $past = clone $date;

        $qb->select('CONCAT(CONCAT(u.firstName, \' \'), u.lastName) AS user,
                      u.chartColor AS chartColor,
                      COUNT( DISTINCT si.storeNumber)')
            ->Join('si.projects', 'pi')
            ->Join('pi.contacts', 'pc')
            ->Join('pc.contact', 'u')
            ->Join('pc.jobrole', 'j')
            ->Join('pi.dates', 'd')
            ->add('where', $qb->expr()->eq(
                '?1',
                'j.jobRole'
              )
            )
            ->andWhere(
              $qb->expr()->gte('d.goPrj', '?2')
              )
            ->groupBy('user')
            ->setParameter(1, "RHA Project Manager")
            ->setParameter(2, $date, \Doctrine\DBAL\Types\Type::DATETIME)
            //->setParameter('date_to',$date_to, \Doctrine\DBAL\Types\Type::DATETIME)
      ;

        $query = $qb->getQuery();

        $result = $query->getArrayResult();

      //$logger->info(print_r($result, true));
      return array('result' => $result);
    }

    /**
     * @Route("/projects", name="rha_pm_loadprojects")
     * @Method("POST")
     * @Template("LimeTrailBundle:City:data.json.twig")
     */
    public function postProjectsAction(Request $request)
    {
        $manager = $request->get('manager');

        $name = explode(' ', $manager);

        $date = new \DateTime(date('Y-m-d'));

        $em = $this->getDoctrine()->getManager('limetrail');

        $qb = $em->getRepository('LimeTrailBundle:StoreInformation')->createQueryBuilder('si');

        $qb->select('DISTINCT si.storeNumber AS number, pi.Sequence AS sequence, pi.canonicalName as name')
          ->Join('si.projects', 'pi')
          ->Join('pi.contacts', 'pc')
          ->Join('pc.contact', 'u')
          ->Join('pc.jobrole', 'j')
          ->Join('pi.dates', 'd')
          ->add('where', $qb->expr()->eq(
                '?1',
                'j.jobRole'
              )
            )
          ->andWhere(
          $qb->expr()->eq('u.firstName', '?2')
          )
          ->andWhere(
          $qb->expr()->eq('u.lastName', '?3')
          )
          ->andWhere(
              $qb->expr()->gte('d.goPrj', '?4')
              )
            ->groupBy('number')
          ->setParameter(1, "RHA Project Manager")
          ->setParameter(2, $name[0])
          ->setParameter(3, $name[1])
          ->setParameter(4, $date, \Doctrine\DBAL\Types\Type::DATETIME)
        ;

        $query = $qb->getQuery();

        $projects = $query->getArrayResult();

        //$logger->info(print_r($result, true));

        $m = array();

        foreach ($projects as $project) {
            array_push($m, array($project['number'].'-'.$project['sequence'].' '.$project['name'], 1));
        }

        $data = array(
          'name' => $manager,
          'type' => 'pie',
          'data' => $m,
        );

        $response = new JsonResponse();

        $response->setData($data);

        return $response;
    }

    /**
     * @Route("/forecast", name="rha_project_forecast")
     * @Template()
     */
    public function forecastAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager('limetrail');

        $date = new \DateTime(date('Y-m-d'));

        $future = clone $date;

        $future->add(new \DateInterval('P3M'));

        $nextYear = clone $date;

        $nextYear->add(new \DateInterval('P01Y'));

        $query = $em->createQuery(
          'SELECT CONCAT(CONCAT(si.storeNumber, \'-\'), pi.Sequence) AS number,
              pi.id,
              pi.canonicalName,
              IF(o.pwoPrj IS NULL, d.pwoPrj, o.pwoPrj) AS pwoPrj,
              IF(o.productionDuration IS NULL,
                IF(o.otpPrj IS NULL,
                  DATE_DIFF( d.otpPrj, IF(o.pwoPrj IS NULL, d.pwoPrj, o.pwoPrj)),
                  DATE_DIFF( o.otpPrj, IF(o.pwoPrj IS NULL, d.pwoPrj, o.pwoPrj))),
                o.productionDuration) AS otpPrj,
              st.name AS type
            FROM LimeTrail\Bundle\Entity\StoreInformation si
            LEFT JOIN si.projects pi
            INNER JOIN pi.dates d
            LEFT JOIN pi.ProjectStatus ps
            LEFT JOIN pi.dateOverride o
            LEFT JOIN si.storeType st
            LEFT JOIN pi.ProgramYear py
            WHERE
              ps.name = ?1
              AND d.runDate = ?2
              AND d.pwoPrj <= ?3
              AND
                (pi.id IN
                  (SELECT p.id
                    FROM LimeTrail\Bundle\Entity\ProjectInformation p
                    INNER JOIN p.dates dt
                    LEFT JOIN p.ProjectStatus pjs
                    WHERE
                      pjs.name = ?1
                      AND dt.runDate = ?2
                      AND dt.otpPrj >= ?2
                   )
                 )
            ORDER BY pwoPrj DESC'
        )
        ->setParameter(1, 'Active')
        ->setParameter(2, $date, \Doctrine\DBAL\Types\Type::DATETIME)
        ->setParameter(3, $future, \Doctrine\DBAL\Types\Type::DATETIME)
        ;

        $result = $query->getArrayResult();

        $logger = $this->container->get('logger');

        foreach ($result as &$entry) {
            $query = $em->createQuery(
            'SELECT CONCAT(CONCAT(u.firstName, \' \'), u.lastName) AS contact,
              u.chartColor AS chartColor
            FROM LimeTrail\Bundle\Entity\ProjectInformation pi
            INNER JOIN pi.contacts pc
            INNER JOIN pc.contact u
            INNER JOIN pc.jobrole j
            WHERE
              pi.id = ?1
              AND j.jobRole = ?2'
          )
          ->setParameters(
            array(
              '1' => $entry['id'],
              '2' => 'RHA Project Manager',
            )
          )
          ;
            $contact = $query->getScalarResult();

            reset($contact);

            $current = current($contact);
            if (empty($current)) {
                $entry['contact'] = ' ';
            } else {
                $entry = array_merge($entry, $current);
                $next = next($contact);
                if (!empty($next)) {
                    $entry = array_merge($entry, $next);
                }
            }

          //$logger->info(print_r($entry, true));
        }

        return array(
                      'result' => $result,
                      'minDate' => $date,
                      'maxDate' => $future,
                    );
    }
}
