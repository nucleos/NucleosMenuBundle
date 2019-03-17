<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\MenuBundle\Menu;

use Knp\Menu\ItemInterface;

interface ConfigBuilderInterface
{
    /**
     * @param array $menu
     * @param array $options
     *
     * @return ItemInterface
     */
    public function buildMenu(array $menu, array $options): ItemInterface;
}
