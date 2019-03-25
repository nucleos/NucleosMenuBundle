<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\MenuBundle\Tests\DependencyInjection;

use Core23\MenuBundle\DependencyInjection\Core23MenuExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

class Core23MenuExtensionTest extends AbstractExtensionTestCase
{
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

        $this->assertContainerBuilderHasService('core23_menu.builder.config');
        $this->assertContainerBuilderHasService('core23_menu.config_provider');

        $this->assertContainerBuilderHasParameter('core23_menu.groups', [
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
            new Core23MenuExtension(),
        ];
    }
}
