<?php

namespace LimeTrail\Bundle\Builders;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Routing\RouterInterface;
use Thrace\DataGridBundle\DataGrid\CustomButton;
use Thrace\DataGridBundle\DataGrid\DataGridFactoryInterface;

/**
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CustomStoreInformationBuilder
{
    const IDENTIFIER = 'mystore_info';
    protected $factory;
    protected $translator;
    protected $router;
    protected $em;
    protected $container;

    public function __construct(DataGridFactoryInterface $factory,
             TranslatorInterface $translator,
             RouterInterface $router,
             EntityManager $em,
             ContainerInterface $container)
    {
        $this->factory = $factory;
        $this->translator = $translator;
        $this->router = $router;
        $this->em = $em;
        $this->container = $container;
    }

    public function build()
    { /* https://github.com/thrace-project/datagrid-bundle/blob/master/Resources/doc/index.md#installation
    http://stackoverflow.com/questions/7413905/jqgrid-populate-select-control-on-row-edit

    */

        $securityContext = $this->container->get('security.context');

        $user = $securityContext->getToken()->getUser();

        $query = $user->getQuery();

        if (!$query) {
            $query = "si.id, si.storeNumber, pi.Sequence as Sequence, s.abbreviation as State, c.name as City, st.name as StoreType, pj.name as ProjectType, p.name as Prototype,
                    d.pwoPrj as PwoProjected, d.pwoAct as PwoActual, d.otpPrj as OtpProjected, d.otpAct as OtpActual, d.otbPrj as OtbProjected, d.otbAct as OtbActual, d.possPrj as PossessionProjected,
                    d.possAct as PossessionActual, d.goPrj as GrandOpeningProjected, d.goAct as GrandOpeningActual,
                    DATE_DIFF(d.possPrj,:today) as DaysToPossession, si";
        }

        $gridModeler = $this->container->get('lime_trail_grid_model.provider');
        $gridModeler->createModel($query);

        $dataGrid = $this->factory->createDataGrid(self::IDENTIFIER);
        $dataGrid
            ->setQueryBuilder($this->getQueryBuilder($query))
            ->setCaption($this->translator->trans('Store Information'))
            ->setColNames($gridModeler->getColNames());

        $dataGrid->setColModel($gridModeler->getColModel());

        $dataGrid->enableSearchButton(true)
            ->enableAddButton(false)
            ->enableEditButton(true)
            ->enableDeleteButton(false)
            ->setSortName('City')
            ->setSortOrder('ASC')
            ->setShrinkToFit(false)
            ->setHeight('100%')
            ->setRowNum(50)
            //->setDependentDataGrids(array('projects_contact'))
        ;

        $dataGrid->addCustomButton(new CustomButton('ExportXls', array(
            'title' => 'Export to Xls',
            'caption' => 'Export',
            'buttonIcon' => 'ui-icon-document',
            'position' => 'last',
            'uri' => $this->router->generate('limetrail_storeinformation_exportgrid',
                      array('grid' => self::IDENTIFIER)
                      ),
            )
          )
        );

        return $dataGrid;
    }

    protected function getQueryBuilder($query)
    {
        $qb = $this->em->getRepository('LimeTrailBundle:StoreInformation')->createQueryBuilder('si');

        $securityContext = $this->container->get('security.context');

        $user = $securityContext->getToken()->getUser();

        $email = $user->getEmailCanonical();

        $date_from = new \DateTime(
          date('Y-m-d',
            strtotime(
              date('Y-m-d').
              " -10 weekdays "
            )
          )
        );
        $date_to = new \DateTime(date('Y-m-d'));

        $qb->select($query)
            ->Join('si.storeType', 'st')
            ->Join('si.city', 'c')
            ->Join('si.state', 's')
            ->Join('si.projects', 'pi')
            ->Join('pi.dates', 'd')
            ->Join('pi.Prototype', 'p')
            ->Join('pi.ProjectType', 'pj')
            ->Join('pi.contacts', 'pc')
            ->Join('pc.contact', 'u')
            ->where(
              $qb->expr()->eq('d.runDate', ':date_to')
              )
           /*->andWhere(
              $qb->expr()->gte('d.goPrj', ':date_to')
              )*/
           ->andWhere('u.email = :e')
           ->andWhere(
                  $qb->expr()->orx(
                    $qb->expr()->gte('d.goAct', ':d'),
                    $qb->expr()->isNull('d.goAct')
                  )
                )
           ->groupBy('si.storeNumber')
           ->setParameter('e', $email)
           ->setParameter('today', $date_to, \Doctrine\DBAL\Types\Type::DATETIME)
           ->setParameter('date_to', $date_to, \Doctrine\DBAL\Types\Type::DATETIME)
           ->setParameter('d', $date_from, \Doctrine\DBAL\Types\Type::DATETIME)
        ;

        return $qb;
    }
}
