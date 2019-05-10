<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\MenuBundle\Tests\DependencyInjection\Compiler;

use Core23\MenuBundle\DependencyInjection\Compiler\MenuCompilerPass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class MenuCompilerPassTest extends TestCase
{
    /**
     * @var ContainerBuilder
     */
    private $container;

    protected function setUp()
    {
        $this->container = new ContainerBuilder();
    }

    public function testProcess(): void
    {
        $definition = $this->createMock(Definition::class);
        $definition->expects(static::once())->method('addMethodCall')
            ->with('add', ['main'])
        ;

        $this->container->setDefinition('sonata.block.menu.registry', $definition);
        $this->container->setParameter('core23_menu.groups', [
            'main' => [
                'name'       => 'FooMenu',
                'attributes' => [
                    'class'    => 'my-class',
                ],
                'items' => [],
            ],
        ]);

        $compiler = new MenuCompilerPass();
        $compiler->process($this->container);
    }

    public function testProcessWithEmptyGroups(): void
    {
        $this->container->setParameter('core23_menu.groups', [
        ]);

        $compiler = new MenuCompilerPass();
        $compiler->process($this->container);

        static::assertTrue(true);
    }
}
