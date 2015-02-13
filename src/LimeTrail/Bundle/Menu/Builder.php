<?php

namespace LimeTrail\Bundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function createMainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array(
            'navbar' => true,
        ));

        $checker = $this->container->get('security.authorization_checker');

        if ($checker->isGranted("IS_AUTHENTICATED_REMEMBERED")) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $userName = $user->getUsername();

            $menu->addChild('Project Tools', array(
                'dropdown' => true,
                'caret' => true,
                ));

            $menu['Project Tools']->addChild('My Projects', array('route' => 'limetrail_storeinformation_customgrid'));
            $menu['Project Tools']->addChild('Store Info', array('route' => 'limetrail_storeinformation'));
            $menu['Project Tools']->addChild('Trident Report', array('route' => 'limetrail_projectdates_aggregated'));
            $menu['Project Tools']->addChild('All Contacts', array('route' => 'trail_contact'));

            if ($checker->isGranted("ROLE_POWER_USER")) {
                $menu->addChild('Management Tools', array(
                'dropdown' => true,
                'caret' => true,
                ));

                $menu['Management Tools']->addChild('Projects By PM', array('route' => 'rha_project_assignments'));
                $menu['Management Tools']->addChild('Shells Due Dates', array('route' => 'limetrail_projectschedule'));
                $menu['Management Tools']->addChild('Project Schedules', array('route' => 'rha_project_forecast'));
                $menu['Management Tools']->addChild('PM Load', array('route' => 'rha_pm_load'));
                $menu['Management Tools']->addChild('Projects by Walmart Client', array(
                    'route' => 'limetrail_storeinformation_walmart_sort',
                    'routeParameters' => array('name' => 'walmart'),
                    ));
            }

            if ($checker->isGranted("ROLE_ADMIN")) {
                $menu->addChild('Financial Tools', array(
                'dropdown' => true,
                'caret' => true,
                ));

                $menu['Financial Tools']->addChild('Contracts', array('route' => 'rha_financial_home'));
            }

            if ($checker->isGranted("ROLE_SUPER_ADMIN")) {
                $menu->addChild('Server Tools', array(
                'dropdown' => true,
                'caret' => true,
                ));

                $menu['Server Tools']->addChild('Admin Dashboard', array('route' => 'sonata_admin_dashboard'));
                $menu['Server Tools']->addChild('Xcache', array('uri' => '/xcache/cacher/index.php'));
                $menu['Server Tools']->addChild('PHPMyadmin', array('uri' => '/phpmyadmin/index.php'));
            }

            $menu->addChild("Hello,$userName", array(
                        'dropdown' => true,
                        'caret' => true,
                        ))
                 ->setAttribute('divider_prepend', true)
                 ->setAttribute('class', 'nav pull-right');

            $menu["Hello,$userName"]->addChild('Logout', array('route' => 'fos_user_security_logout'));
            $menu["Hello,$userName"]->addChild('My Profile', array('route' => 'fos_user_profile_show'));
        } else {
            $menu->addChild('Log In', array('route' => 'fos_user_security_login'))
                 ->setAttribute('divider_prepend', true)
                 ->setAttribute('class', 'nav pull-right');
        }

        return $menu;
    }
    public function createNavbarsSubnavMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array(
            'subnavbar' => true,
        ));
        $menu->addChild('Top', array('uri' => '#top'));
        $menu->addChild('Menus', array('uri' => '#menus'));
        $menu->addChild('Navbars', array('uri' => '#navbars'));
        $menu->addChild('Template', array('uri' => '#template'));
        // ... add more children
        return $menu;
    }
    public function createComponentsSubnavMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array(
            'subnavbar' => true,
        ));
        $menu->addChild('Top', array('uri' => '#top'));
        $menu->addChild('Flashs', array('uri' => '#flashs'));
        $menu->addChild('Session Flashs', array('uri' => '#session-flashes'));
        $menu->addChild('Labels & Badges', array('uri' => '#labels-badges'));
        // ... add more children
        return $menu;
    }
}
