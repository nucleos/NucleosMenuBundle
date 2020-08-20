<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\MenuBundle\Tests\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Nucleos\MenuBundle\Menu\ConfigBuilder;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Symfony\Contracts\Translation\TranslatorInterface;

final class ConfigBuilderTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @var MockObject&FactoryInterface
     */
    private $factory;

    /**
     * @var MockObject&TranslatorInterface
     */
    private $translator;

    protected function setUp(): void
    {
        $this->factory         = $this->createMock(FactoryInterface::class);
        $this->translator      = $this->createMock(TranslatorInterface::class);
    }

    public function testBuildMenuWithoutItems(): void
    {
        $builder = new ConfigBuilder(
            $this->factory,
            $this->translator
        );

        $mainMenu = $this->createMock(ItemInterface::class);

        $this->factory->method('createItem')
            ->with('main', [
                'attributes' => [
                    'class' => 'nav',
                ],
                'childrenAttributes' => [
                    'class' => 'nav nav-pills',
                ],
            ])
            ->willReturn($mainMenu)
        ;

        static::assertSame($mainMenu, $builder->buildMenu([], []));
    }

    public function testBuildMenuWithOptions(): void
    {
        $builder = new ConfigBuilder(
            $this->factory,
            $this->translator
        );

        $mainMenu = $this->createMock(ItemInterface::class);

        $this->factory->method('createItem')
            ->with('main', [
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

        static::assertSame($mainMenu, $builder->buildMenu([], [
            'foo' => 'bar',
        ]));
    }

    public function testBuildMenuWithMenuAttributes(): void
    {
        $builder = new ConfigBuilder(
            $this->factory,
            $this->translator
        );

        $mainMenu = $this->createMock(ItemInterface::class);

        $this->factory->method('createItem')
            ->with('main', [
                'attributes' => [
                    'class' => 'nav',
                ],
                'childrenAttributes' => [
                    'attr-foo' => 'custom',
                ],
            ])
            ->willReturn($mainMenu)
            ;

        static::assertSame($mainMenu, $builder->buildMenu([
            'attributes' => [
                'attr-foo' => 'custom',
            ],
        ], []));
    }

    public function testBuildMenuWithItems(): void
    {
        $builder = new ConfigBuilder(
            $this->factory,
            $this->translator
        );

        $item = $this->createMock(ItemInterface::class);

        $mainMenu = $this->createMock(ItemInterface::class);
        $mainMenu->expects(static::once())->method('addChild')
            ->with($item)
        ;

        $this->factory->expects(static::exactly(2))->method('createItem')
            ->withConsecutive(
                ['main', [
                    'attributes' => [
                        'class' => 'nav',
                    ],
                    'childrenAttributes' => [
                        'class' => 'nav nav-pills',
                    ],
                ]],
                ['my-label', [
                    'route'           => 'my-route',
                    'routeParameters' => [
                        'paramKey' => 'value',
                    ],
                    'linkAttributes'  => ['class' => 'my-class'],
                    'extras'          => [
                        'safe_label'         => true,
                        'translation_domain' => false,
                    ],
                ]]
            )
            ->willReturn(
                $mainMenu,
                $item
            )
        ;

        static::assertSame($mainMenu, $builder->buildMenu([
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
            $this->factory,
            $this->translator
        );

        $item = $this->createMock(ItemInterface::class);

        $mainMenu = $this->createMock(ItemInterface::class);
        $mainMenu->expects(static::once())->method('addChild')
            ->with($item)
        ;

        $this->factory->expects(static::exactly(2))->method('createItem')
            ->withConsecutive(
                ['main', [
                    'attributes' => [
                        'class' => 'nav',
                    ],
                    'childrenAttributes' => [
                        'class' => 'nav nav-pills',
                    ],
                ]],
                ['My label', [
                    'route'           => 'my-route',
                    'routeParameters' => [],
                    'linkAttributes'  => [],
                    'extras'          => [
                        'safe_label'         => true,
                        'translation_domain' => false,
                    ],
                ]]
            )
            ->willReturn(
                $mainMenu,
                $item
            )
        ;

        $this->translator->method('trans')
            ->with('my-label', [], 'App')
            ->willReturn('My label')
        ;

        static::assertSame($mainMenu, $builder->buildMenu([
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
            $this->factory,
            $this->translator
        );

        $item = $this->createMock(ItemInterface::class);

        $mainMenu = $this->createMock(ItemInterface::class);
        $mainMenu->expects(static::once())->method('addChild')
            ->with($item)
        ;

        $this->factory->expects(static::exactly(2))->method('createItem')
            ->withConsecutive(
                ['main', [
                    'attributes' => [
                        'class' => 'nav',
                    ],
                    'childrenAttributes' => [
                        'class' => 'nav nav-pills',
                    ],
                ]],
                ['<i class="fa fa-test"></i> my-label', [
                    'route'           => 'my-route',
                    'routeParameters' => [],
                    'linkAttributes'  => [],
                    'extras'          => [
                        'safe_label'         => true,
                        'translation_domain' => false,
                    ],
                ]]
            )
            ->willReturn(
                $mainMenu,
                $item
            )
        ;

        static::assertSame($mainMenu, $builder->buildMenu([
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
            $this->factory,
            $this->translator
        );

        $item = $this->createMock(ItemInterface::class);
        $item->expects(static::once())->method('addChild')
            ->with($item)
        ;

        $mainMenu = $this->createMock(ItemInterface::class);
        $mainMenu->expects(static::once())->method('addChild')
            ->with($item)
        ;

        $this->factory->expects(static::exactly(3))->method('createItem')
            ->withConsecutive(
                ['main', [
                    'attributes' => [
                        'class' => 'nav',
                    ],
                    'childrenAttributes' => [
                        'class' => 'nav nav-pills',
                    ],
                ]],
                ['my-label <b class="caret caret-menu"></b>', [
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
                ]],
                ['my-sub-label', [
                    'route'           => 'my-sub-route',
                    'routeParameters' => [],
                    'linkAttributes'  => [],
                    'extras'          => [
                        'safe_label'         => true,
                        'translation_domain' => false,
                    ],
                ]],
            )
            ->willReturn(
                $mainMenu,
                $item,
                $item,
            )
        ;

        static::assertSame($mainMenu, $builder->buildMenu([
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
