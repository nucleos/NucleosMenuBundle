<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\MenuBundle\Provider;

use Core23\MenuBundle\Menu\ConfigBuilder;
use Knp\Menu\Provider\MenuProviderInterface;

final class ConfigProvider implements MenuProviderInterface
{
    /**
     * @var ConfigBuilder
     */
    private $builder;

    /**
     * @var array
     */
    private $menus;

    /**
     * ConfigProvider constructor.
     *
     * @param ConfigBuilder $builder
     * @param array         $menuIds
     */
    public function __construct(ConfigBuilder $builder, array $menuIds)
    {
        $this->builder = $builder;
        $this->menus   = $menuIds;
    }

    /**
     * {@inheritdoc}
     */
    public function get($name, array $options = array())
    {
        if (!$this->has($name)) {
            throw new \InvalidArgumentException(sprintf('The menu "%s" is not defined.', $name));
        }

        return $this->builder->buildMenu($this->menus[$name], $options);
    }

    /**
     * {@inheritdoc}
     */
    public function has($name, array $options = array())
    {
        return isset($this->menus[$name]);
    }
}
