<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\MenuBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Translation\TranslatorInterface;

final class ConfigBuilder implements ConfigBuilderInterface
{
    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var array
     */
    private $defaultOptions;

    public function __construct(FactoryInterface $factory, TranslatorInterface $translator)
    {
        $this->factory    = $factory;
        $this->translator = $translator;

        $this->defaultOptions = [
            'attributes' => [
                'class' => 'dropdown',
            ],
            'childrenAttributes' => [
                'class' => 'dropdown-menu',
            ],
            'linkAttributes' => [
                'class'       => 'dropdown-toggle',
                'data-toggle' => 'dropdown',
                'data-target' => '#',
            ],
            'extras' => [
                'safe_label'         => true,
                'translation_domain' => false,
            ],
        ];
    }

    public function buildMenu(array $menu, array $options): ItemInterface
    {
        $menuOptions = array_merge_recursive([
            'attributes' => [
                'class' => 'nav',
            ],
            'childrenAttributes' => [
                'class' => 'nav nav-pills',
            ],
        ], $options);

        if (\array_key_exists('attributes', $menu)) {
            $menuOptions = array_merge($menuOptions, [
                'childrenAttributes' => $menu['attributes'],
            ]);
        }

        $menuItem = $this->factory->createItem('main', $menuOptions);

        if (\array_key_exists('items', $menu)) {
            $this->buildSubMenu($menuItem, $menu['items']);
        }

        return $menuItem;
    }

    private function buildSubMenu(ItemInterface $menu, array $configItems, array $baseMenuOptions = []): ItemInterface
    {
        foreach ($configItems as $item) {
            $this->createItem($menu, $baseMenuOptions, $item);
        }

        return $menu;
    }

    private function trans(string $id, string $domain): string
    {
        return $this->translator->trans($id, [], $domain);
    }

    private function createItem(ItemInterface $menu, array $baseMenuOptions, array $itemDefinition): void
    {
        $label = $this->createLabel($itemDefinition);

        $menuOptions = self::getOptions($baseMenuOptions, $itemDefinition);

        if (\array_key_exists('children', $itemDefinition) && \count($itemDefinition['children']) > 0) {
            $label       .= ' <b class="caret caret-menu"></b>';
            $menuOptions = array_merge($menuOptions, $this->defaultOptions, [
                'label' => $label,
            ]);
        }

        $subMenu = $this->factory->createItem($label, $menuOptions);
        $menu->addChild($subMenu);

        if (\array_key_exists('children', $itemDefinition) && \count($itemDefinition['children']) > 0) {
            $this->buildSubMenu($subMenu, $itemDefinition['children']);
        }
    }

    private function createLabel(array $itemDefinition): string
    {
        $label = $itemDefinition['label'];

        if (\array_key_exists('label_catalogue', $itemDefinition) && false !== $itemDefinition['label_catalogue']) {
            $label = $this->trans($itemDefinition['label'], $itemDefinition['label_catalogue']);
        }

        if (\array_key_exists('icon', $itemDefinition) && \is_string($itemDefinition['icon'])) {
            $label = '<i class="'.$itemDefinition['icon'].'"></i> '.$label;
        }

        return $label;
    }

    private static function getOptions(array $baseMenuOptions, array $itemDefinition): array
    {
        $options = array_merge($baseMenuOptions, [
            'route'           => $itemDefinition['route'],
            'routeParameters' => $itemDefinition['routeParams'] ?? [],
            'linkAttributes'  => [],
            'extras'          => [
                'safe_label'         => true,
                'translation_domain' => false,
            ],
        ]);

        if (\array_key_exists('class', $itemDefinition)) {
            $options['linkAttributes']['class'] = $itemDefinition['class'];
        }

        return $options;
    }
}
