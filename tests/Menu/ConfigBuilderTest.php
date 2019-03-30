<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\MenuBundle\Tests\Menu;

use Core23\MenuBundle\Menu\ConfigBuilder;
use Core23\MenuBundle\Menu\ConfigBuilderInterface;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Translation\TranslatorInterface;

class ConfigBuilderTest extends TestCase
{
    private $factory;

    private $translator;

    protected function setUp()
    {
        $this->factory         = $this->prophesize(FactoryInterface::class);
        $this->translator      = $this->prophesize(TranslatorInterface::class);
    }

    public function testItIsInstantiable(): void
    {
        $builder = new ConfigBuilder(
            $this->factory->reveal(),
            $this->translator->reveal(),
            );

        $this->assertInstanceOf(ConfigBuilderInterface::class, $builder);
    }

    public function testBuildMenuWithoutItems(): void
    {
        $builder = new ConfigBuilder(
            $this->factory->reveal(),
            $this->translator->reveal(),
            );

        $mainMenu = $this->prophesize(ItemInterface::class);

        $this->factory->createItem('main', [
            'attributes' => [
                'class' => 'nav',
            ],
            'childrenAttributes' => [
                'class' => 'nav nav-pills',
            ],
        ])
        ->willReturn($mainMenu)
        ;

        $this->assertSame($mainMenu->reveal(), $builder->buildMenu([], []));
    }

    public function testBuildMenuWithOptions(): void
    {
        $builder = new ConfigBuilder(
            $this->factory->reveal(),
            $this->translator->reveal(),
            );

        $mainMenu = $this->prophesize(ItemInterface::class);

        $this->factory->createItem('main', [
            'attributes' => [
                'class' => 'nav',
            ],
            'childrenAttributes' => [
                'class' => 'nav nav-pills',
            ],
            'foo' => 'bar',
        ])
        ->willReturn($mainMenu)
        ;

        $this->assertSame($mainMenu->reveal(), $builder->buildMenu([], [
            'foo' => 'bar',
        ]));
    }

    public function testBuildMenuWithMenuAttributes(): void
    {
        $builder = new ConfigBuilder(
            $this->factory->reveal(),
            $this->translator->reveal(),
            );

        $mainMenu = $this->prophesize(ItemInterface::class);

        $this->factory->createItem('main', [
            'attributes' => [
                'class' => 'nav',
            ],
            'childrenAttributes' => [
                'attr-foo' => 'custom',
            ],
        ])
        ->willReturn($mainMenu)
        ;

        $this->assertSame($mainMenu->reveal(), $builder->buildMenu([
            'attributes' => [
                'attr-foo' => 'custom',
            ],
        ], []));
    }

    public function testBuildMenuWithItems(): void
    {
        $builder = new ConfigBuilder(
            $this->factory->reveal(),
            $this->translator->reveal(),
            );

        $item = $this->prophesize(ItemInterface::class);

        $mainMenu = $this->prophesize(ItemInterface::class);
        $mainMenu->addChild($item);

        $this->factory->createItem('main', [
            'attributes' => [
                'class' => 'nav',
            ],
            'childrenAttributes' => [
                'class' => 'nav nav-pills',
            ],
        ])
        ->willReturn($mainMenu)
        ;

        $this->factory->createItem('my-label', [
            'route'           => 'my-route',
            'routeParameters' => [
                'paramKey' => 'value',
            ],
            'linkAttributes'  => ['class' => 'my-class'],
            'extras'          => [
                'safe_label'         => true,
                'translation_domain' => false,
            ],
        ])
        ->willReturn($item)
        ;

        $this->assertSame($mainMenu->reveal(), $builder->buildMenu([
            'items' => [
                [
                    'label'       => 'my-label',
                    'route'       => 'my-route',
                    'routeParams' => [
                        'paramKey' => 'value',
                    ],
                    'class' => 'my-class',
                ],
            ],
        ], []));
    }

    public function testBuildMenuWithTranslation(): void
    {
        $builder = new ConfigBuilder(
            $this->factory->reveal(),
            $this->translator->reveal(),
            );

        $item = $this->prophesize(ItemInterface::class);

        $mainMenu = $this->prophesize(ItemInterface::class);
        $mainMenu->addChild($item);

        $this->factory->createItem('main', [
            'attributes' => [
                'class' => 'nav',
            ],
            'childrenAttributes' => [
                'class' => 'nav nav-pills',
            ],
        ])
        ->willReturn($mainMenu)
        ;

        $this->factory->createItem('My label', [
            'route'           => 'my-route',
            'routeParameters' => [],
            'linkAttributes'  => [],
            'extras'          => [
                'safe_label'         => true,
                'translation_domain' => false,
            ],
        ])
        ->willReturn($item)
        ;

        $this->translator->trans('my-label', [], 'App')
            ->willReturn('My label')
        ;

        $this->assertSame($mainMenu->reveal(), $builder->buildMenu([
            'items' => [
                [
                    'label'           => 'my-label',
                    'label_catalogue' => 'App',
                    'route'           => 'my-route',
                ],
            ],
        ], []));
    }

    public function testBuildMenuWithIcon(): void
    {
        $builder = new ConfigBuilder(
            $this->factory->reveal(),
            $this->translator->reveal(),
            );

        $item = $this->prophesize(ItemInterface::class);

        $mainMenu = $this->prophesize(ItemInterface::class);
        $mainMenu->addChild($item);

        $this->factory->createItem('main', [
            'attributes' => [
                'class' => 'nav',
            ],
            'childrenAttributes' => [
                'class' => 'nav nav-pills',
            ],
        ])
        ->willReturn($mainMenu)
        ;

        $this->factory->createItem('<i class="fa fa-test"></i> my-label', [
            'route'           => 'my-route',
            'routeParameters' => [],
            'linkAttributes'  => [],
            'extras'          => [
                'safe_label'         => true,
                'translation_domain' => false,
            ],
        ])
        ->willReturn($item)
        ;

        $this->assertSame($mainMenu->reveal(), $builder->buildMenu([
            'items' => [
                [
                    'label' => 'my-label',
                    'icon'  => 'fa fa-test',
                    'route' => 'my-route',
                ],
            ],
        ], []));
    }

    public function testBuildMenuWithChildren(): void
    {
        $builder = new ConfigBuilder(
            $this->factory->reveal(),
            $this->translator->reveal(),
            );

        $subitem = $this->prophesize(ItemInterface::class);

        $item = $this->prophesize(ItemInterface::class);
        $item->addChild($subitem);

        $mainMenu = $this->prophesize(ItemInterface::class);
        $mainMenu->addChild($item);

        $this->factory->createItem('main', [
            'attributes' => [
                'class' => 'nav',
            ],
            'childrenAttributes' => [
                'class' => 'nav nav-pills',
            ],
        ])
        ->willReturn($mainMenu)
        ;

        $this->factory->createItem('my-label <b class="caret caret-menu"></b>', [
            'route'           => 'my-route',
            'routeParameters' => [],
            'linkAttributes'  => [
                'class'       => 'dropdown-toggle',
                'data-toggle' => 'dropdown',
                'data-target' => '#',
            ],
            'extras' => [
                'safe_label'         => true,
                'translation_domain' => false,
            ],
            'attributes' => [
                'class' => 'dropdown',
            ],
            'childrenAttributes' => [
                'class' => 'dropdown-menu',
            ],
            'label' => 'my-label <b class="caret caret-menu"></b>',
        ])
        ->willReturn($item)
        ;

        $this->factory->createItem('my-sub-label', [
            'route'           => 'my-sub-route',
            'routeParameters' => [],
            'linkAttributes'  => [],
            'extras'          => [
                'safe_label'         => true,
                'translation_domain' => false,
            ],
        ])
        ->willReturn($item)
        ;

        $this->assertSame($mainMenu->reveal(), $builder->buildMenu([
            'items' => [
                [
                    'label'       => 'my-label',
                    'route'       => 'my-route',
                    'class'       => 'my-class',
                    'children'    => [
                        [
                            'label'  => 'my-sub-label',
                            'route'  => 'my-sub-route',
                        ],
                    ],
                ],
            ],
        ], []));
    }
}
