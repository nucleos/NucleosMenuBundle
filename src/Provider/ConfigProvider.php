<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\MenuBundle\Provider;

use Core23\MenuBundle\Menu\ConfigBuilderInterface;
use InvalidArgumentException;
use Knp\Menu\ItemInterface;
use Knp\Menu\Provider\MenuProviderInterface;

final class ConfigProvider implements MenuProviderInterface
{
    /**
     * @var ConfigBuilderInterface
     */
    private $builder;

    /**
     * @var array<string, mixed>
     */
    private $menus;

    /**
     * @param ConfigBuilderInterface $builder
     * @param array                  $menuIds
     */
    public function __construct(ConfigBuilderInterface $builder, array $menuIds)
    {
        $this->builder = $builder;
        $this->menus   = $menuIds;
    }

    /**
     * {@inheritdoc}
     */
    public function get($name, array $options = []): ItemInterface
    {
        if (!$this->has($name)) {
            throw new InvalidArgumentException(sprintf('The menu "%s" is not defined.', $name));
        }

        return $this->builder->buildMenu($this->menus[$name], $options);
    }

    /**
     * {@inheritdoc}
     */
    public function has($name, array $options = []): bool
    {
        return isset($this->menus[$name]);
    }
}
