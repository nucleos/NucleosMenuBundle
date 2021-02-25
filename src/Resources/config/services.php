<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Nucleos\MenuBundle\Menu\ConfigBuilder;
use Nucleos\MenuBundle\Provider\ConfigProvider;
use Symfony\Component\DependencyInjection\Parameter;
use Symfony\Component\DependencyInjection\Reference;

return static function (ContainerConfigurator $container): void {
    $container->services()

        ->set('nucleos_menu.builder.config', ConfigBuilder::class)
            ->args([
                new Reference('knp_menu.factory'),
                new Parameter('translator'),
            ])

        ->set('nucleos_menu.config_provider', ConfigProvider::class)
            ->tag('knp_menu.provider')
            ->args([
                new Reference('nucleos_menu.builder.config'),
                new Parameter('nucleos_menu.groups'),
            ])

    ;
};
