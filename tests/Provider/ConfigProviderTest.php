<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\MenuBundle\Tests\Provider;

use InvalidArgumentException;
use Knp\Menu\ItemInterface;
use Nucleos\MenuBundle\Menu\ConfigBuilderInterface;
use Nucleos\MenuBundle\Provider\ConfigProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class ConfigProviderTest extends TestCase
{
    /**
     * @var ConfigBuilderInterface&MockObject
     */
    private ConfigBuilderInterface $configBuilder;

    protected function setUp(): void
    {
        $this->configBuilder = $this->createMock(ConfigBuilderInterface::class);
    }

    public function testGet(): void
    {
        $menu = $this->createMock(ItemInterface::class);

        $this->configBuilder->method('buildMenu')->with(['name' => 'foo'], ['a' => 'b'])
            ->willReturn($menu)
        ;

        $configProvider = new ConfigProvider($this->configBuilder, [
            'foo' => ['name' => 'foo'],
            'bar' => ['name' => 'bar'],
        ]);
        self::assertSame($menu, $configProvider->get('foo', ['a' => 'b']));
    }

    public function testGetDoesNotExist(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $configProvider = new ConfigProvider($this->configBuilder, [
            'foo' => ['name' => 'foo'],
            'bar' => ['name' => 'bar'],
        ]);
        $configProvider->get('baz');
    }

    public function testHas(): void
    {
        $configProvider = new ConfigProvider($this->configBuilder, [
            'foo' => ['name' => 'foo'],
            'bar' => ['name' => 'bar'],
        ]);

        self::assertTrue($configProvider->has('foo'));
    }

    public function testHasNot(): void
    {
        $configProvider = new ConfigProvider($this->configBuilder, [
            'foo' => ['name' => 'foo'],
            'bar' => ['name' => 'bar'],
        ]);

        self::assertFalse($configProvider->has('baz'));
    }
}
