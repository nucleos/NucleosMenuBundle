<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\MenuBundle\Tests\DependencyInjection;

use Core23\MenuBundle\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends TestCase
{
    public function testOptions(): void
    {
        $processor = new Processor();

        $config = $processor->processConfiguration(new Configuration(), []);

        $expected = [
            'groups' => [
            ],
        ];

        static::assertSame($expected, $config);
    }

    public function testGroupsOptions(): void
    {
        $processor = new Processor();

        $config = $processor->processConfiguration(new Configuration(), [[
            'groups' => [
                'test' => [
                    'name'       => 'FooMenu',
                    'attributes' => [
                        'class'    => 'my-class',
                    ],
                    'items' => [
                        'foo' => [
                            'label'    => 'my-label',
                            'children' => [
                                'subfoo' => [
                                    'label' => 'my-sub-label',
                                    'route' => 'my-subroute',
                                ],
                            ],
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
        ]]);

        $expected = [
            'groups' => [
                'test' => [
                    'name'       => 'FooMenu',
                    'attributes' => [
                        'class'    => 'my-class',
                    ],
                    'items'           => [
                        'foo' => [
                            'label'    => 'my-label',
                            'children' => [
                                'subfoo' => [
                                    'label'           => 'my-sub-label',
                                    'route'           => 'my-subroute',
                                    'label_catalogue' => false,
                                    'icon'            => null,
                                    'class'           => null,
                                    'routeParams'     => [],
                                    'children'        => [],
                                ],
                            ],
                            'label_catalogue' => false,
                            'icon'            => null,
                            'class'           => null,
                            'route'           => null,
                            'routeParams'     => [],
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
            ],
        ];

        static::assertSame($expected, $config);
    }
}
