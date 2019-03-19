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

    /**
     * @param FactoryInterface    $factory
     * @param TranslatorInterface $translator
     */
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

    /**
     * {@inheritdoc}
     */
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

    /**
     * @param ItemInterface $menu
     * @param array         $configItems
     * @param array         $baseMenuOptions
     *
     * @return ItemInterface
     */
    private function buildSubMenu(ItemInterface $menu, array $configItems, array $baseMenuOptions = []): ItemInterface
    {
        foreach ($configItems as $item) {
            $this->createItem($menu, $baseMenuOptions, $item);
        }

        return $menu;
    }

    /**
     * @param string            $id
     * @param array             $parameters
     * @param false|string|null $domain
     * @param string|null       $locale
     *
     * @return string
     */
    private function trans(string $id, array $parameters = [], $domain = null, $locale = null): string
    {
        if (false === $domain) {
            return $id;
        }

        return $this->translator->trans($id, $parameters, $domain, $locale);
    }

    /**
     * @param ItemInterface $menu
     * @param array         $baseMenuOptions
     * @param array         $itemDefinition
     */
    private function createItem(ItemInterface $menu, array $baseMenuOptions, array $itemDefinition): void
    {
        $label = $this->trans($itemDefinition['label'], [], $itemDefinition['label_catalogue']);

        if (!empty($itemDefinition['icon'])) {
            $label = '<i class="'.$itemDefinition['icon'].'"></i> '.$label;
        }

        $menuOptions = self::getOptions($baseMenuOptions, $itemDefinition);

        if (\count($itemDefinition['children']) > 0) {
            $label       .= ' <b class="caret caret-menu"></b>';
            $menuOptions = array_merge($menuOptions, $this->defaultOptions, [
                'label' => $label,
            ]);
        }

        $subMenu = $this->factory->createItem($label, $menuOptions);
        $menu->addChild($subMenu);

        if (\count($itemDefinition['children']) > 0) {
            $this->buildSubMenu($subMenu, $itemDefinition['children']);
        }
    }

    /**
     * @param array $baseMenuOptions
     * @param array $itemDefinition
     *
     * @return array
     */
    private static function getOptions(array $baseMenuOptions, array $itemDefinition): array
    {
        return array_merge($baseMenuOptions, [
            'route'           => $itemDefinition['route'],
            'routeParameters' => $itemDefinition['routeParams'],
            'linkAttributes'  => ['class' => $itemDefinition['class']],
            'extras'          => [
                'safe_label'         => true,
                'translation_domain' => false,
            ],
        ]);
    }
}
