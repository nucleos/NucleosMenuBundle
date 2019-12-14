<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\MenuBundle\Tests\Provider;

use Core23\MenuBundle\Menu\ConfigBuilderInterface;
use Core23\MenuBundle\Provider\ConfigProvider;
use InvalidArgumentException;
use Knp\Menu\ItemInterface;
use PHPUnit\Framework\TestCase;

final class ConfigProviderTest extends TestCase
{
    private $configBuilder;

    protected function setUp(): void
    {
        $this->configBuilder = $this->prophesize(ConfigBuilderInterface::class);
    }

    public function testGet(): void
    {
        $menu = $this->prophesize(ItemInterface::class);

        $this->configBuilder->buildMenu(['name' => 'foo'], ['a' => 'b'])->willReturn($menu);

        $configProvider = new ConfigProvider($this->configBuilder->reveal(), [
            'foo' => ['name' => 'foo'],
            'bar' => ['name' => 'bar'],
        ]);
        static::assertSame($menu->reveal(), $configProvider->get('foo', ['a' => 'b']));
    }

    public function testGetDoesNotExist(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $configProvider = new ConfigProvider($this->configBuilder->reveal(), [
            'foo' => ['name' => 'foo'],
            'bar' => ['name' => 'bar'],
        ]);
        $configProvider->get('baz');
    }

    public function testHas(): void
    {
        $configProvider = new ConfigProvider($this->configBuilder->reveal(), [
            'foo' => ['name' => 'foo'],
            'bar' => ['name' => 'bar'],
        ]);

        static::assertTrue($configProvider->has('foo'));
    }

    public function testHasNot(): void
    {
        $configProvider = new ConfigProvider($this->configBuilder->reveal(), [
            'foo' => ['name' => 'foo'],
            'bar' => ['name' => 'bar'],
        ]);

        static::assertFalse($configProvider->has('baz'));
    }
}
