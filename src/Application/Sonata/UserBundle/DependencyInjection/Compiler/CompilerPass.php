<?php

namespace Application\Sonata\UserBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('sonata.user.block.breadcrumb_profile');
        $definition->setClass('Application\Sonata\UserBundle\Block\Breadcrumb\UserProfileBreadcrumbBlockService');
    }
}
