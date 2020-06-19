<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\MenuBundle\Tests\DependencyInjection\Compiler;

use Nucleos\MenuBundle\DependencyInjection\Compiler\MenuCompilerPass;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

final class MenuCompilerPassTest extends TestCase
{
    /**
     * @var ContainerBuilder
     */
    private $container;

    /**
     * @var ObjectProphecy
     */
    private $registryDefinitionMock;

    protected function setUp(): void
    {
        $this->registryDefinitionMock = $this->prophesize(Definition::class);

        $this->container = new ContainerBuilder();
        $this->container->setDefinition('sonata.block.menu.registry', $this->registryDefinitionMock->reveal());
    }

    public function testProcess(): void
    {
        $definition = $this->createMock(Definition::class);
        $definition->expects(static::once())->method('addMethodCall')
            ->with('add', ['main'])
        ;

        $this->container->setDefinition('sonata.block.menu.registry', $definition);
        $this->container->setParameter('nucleos_menu.groups', [
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
        $this->container->setParameter('nucleos_menu.groups', [
        ]);

        $compiler = new MenuCompilerPass();
        $compiler->process($this->container);

        $this->registryDefinitionMock->addMethodCall(Argument::any())->shouldNotHaveBeenCalled();
    }
}
