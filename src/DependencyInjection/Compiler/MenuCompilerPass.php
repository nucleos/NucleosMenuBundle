<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\MenuBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class MenuCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $groups = $container->getParameter('nucleos_menu.groups');

        if (!\is_array($groups) || 0 === \count($groups)) {
            return;
        }

        $registry = $container->getDefinition('sonata.block.menu.registry');

        foreach ($groups as $name => $items) {
            $registry->addMethodCall('add', [$name]);
        }
    }
}
