<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\MenuBundle\Provider;

use InvalidArgumentException;
use Knp\Menu\ItemInterface;
use Knp\Menu\Provider\MenuProviderInterface;
use Nucleos\MenuBundle\Menu\ConfigBuilderInterface;

final class ConfigProvider implements MenuProviderInterface
{
    private ConfigBuilderInterface $builder;

    /**
     * @var array<string, mixed>
     */
    private array $menus;

    public function __construct(ConfigBuilderInterface $builder, array $menuIds)
    {
        $this->builder = $builder;
        $this->menus   = $menuIds;
    }

    public function get($name, array $options = []): ItemInterface
    {
        if (!$this->has($name)) {
            throw new InvalidArgumentException(sprintf('The menu "%s" is not defined.', $name));
        }

        return $this->builder->buildMenu($this->menus[$name], $options);
    }

    public function has($name, array $options = []): bool
    {
        return isset($this->menus[$name]);
    }
}
