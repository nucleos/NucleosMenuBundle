<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\MenuBundle\Tests;

use Core23\MenuBundle\Core23MenuBundle;
use PHPUnit\Framework\TestCase;

class Core23MenuBundleTest extends TestCase
{
    public function testItIsInstantiable(): void
    {
        $bundle = new Core23MenuBundle();

        $this->assertInstanceOf(Core23MenuBundle::class, $bundle);
    }
}
