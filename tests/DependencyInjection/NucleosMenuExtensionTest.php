<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\MenuBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Nucleos\MenuBundle\DependencyInjection\NucleosMenuExtension;

final class NucleosMenuExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function testLoadDefault(): void
    {
        $this->load([
            'groups' => [
                'test' => [
                    'name'       => 'FooMenu',
                    'attributes' => [
                        'class'    => 'my-class',
                    ],
                    'items' => [
                        'foo' => [
                            'label'    => 'my-label',
                        ],
                        'bar' => [
                            'label'       => 'my-other-label',
                            'icon'        => 'fa fa-home',
                            'route'       => 'my-route',
                            'routeParams' => ['foo' => 'bar'],
                        ],
                    ],
                ],
            ],
        ]);

        $this->assertContainerBuilderHasService('nucleos_menu.builder.config');
        $this->assertContainerBuilderHasService('nucleos_menu.config_provider');

        $this->assertContainerBuilderHasParameter('nucleos_menu.groups', [
            'static_test' => [
                'name'       => 'FooMenu',
                'attributes' => [
                    'class'    => 'my-class',
                ],
                'items'           => [
                    'foo' => [
                        'label'           => 'my-label',
                        'label_catalogue' => false,
                        'icon'            => null,
                        'class'           => null,
                        'route'           => null,
                        'routeParams'     => [],
                        'children'        => [],
                    ],
                    'bar' => [
                        'label'           => 'my-other-label',
                        'icon'            => 'fa fa-home',
                        'route'           => 'my-route',
                        'routeParams'     => ['foo' => 'bar'],
                        'label_catalogue' => false,
                        'class'           => null,
                        'children'        => [],
                    ],
                ],
            ],
        ]);
    }

    protected function getContainerExtensions(): array
    {
        return [
            new NucleosMenuExtension(),
        ];
    }
}
