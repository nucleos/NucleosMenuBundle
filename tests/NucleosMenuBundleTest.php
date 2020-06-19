<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\MenuBundle\Tests;

use Nucleos\MenuBundle\DependencyInjection\Compiler\MenuCompilerPass;
use Nucleos\MenuBundle\DependencyInjection\NucleosMenuExtension;
use Nucleos\MenuBundle\NucleosMenuBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class NucleosMenuBundleTest extends TestCase
{
    public function testGetContainerExtension(): void
    {
        $bundle = new NucleosMenuBundle();

        static::assertInstanceOf(NucleosMenuExtension::class, $bundle->getContainerExtension());
    }

    public function testBuild(): void
    {
        $containerBuilder = $this->createMock(ContainerBuilder::class);

        $containerBuilder->expects(static::once())->method('addCompilerPass')
            ->with(static::isInstanceOf(MenuCompilerPass::class))
        ;

        $bundle = new NucleosMenuBundle();
        $bundle->build($containerBuilder);
    }
}
