<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\MenuBundle\Menu;

use Knp\Menu\ItemInterface;

interface ConfigBuilderInterface
{
    public function buildMenu(array $menu, array $options): ItemInterface;
}
