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

final class ConfigBuilder
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
     * @param FactoryInterface    $factory
     * @param TranslatorInterface $translator
     */
    public function __construct(FactoryInterface $factory, TranslatorInterface $translator)
    {
        $this->factory    = $factory;
        $this->translator = $translator;
    }

    /**
     * @param array $menu
     * @param array $options
     *
     * @return ItemInterface
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

        if (array_key_exists('attributes', $menu)) {
            $menuOptions = array_merge($menuOptions, [
                'childrenAttributes' => $menu['attributes'],
            ]);
        }

        $menuItem = $this->factory->createItem('main', $menuOptions);

        if (array_key_exists('items', $menu)) {
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
        $subMenuOptions = [
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

        foreach ($configItems as $item) {
            $label = $this->trans($item['label'], [], $item['label_catalogue']);

            if (!empty($item['icon'])) {
                $label = '<i class="'.$item['icon'].'"></i> '.$label;
            }

            $menuOptions = array_merge($baseMenuOptions, [
                'route'           => $item['route'],
                'routeParameters' => $item['routeParams'],
                'linkAttributes'  => ['class' => $item['class']],
                'extras'          => [
                    'safe_label'         => true,
                    'translation_domain' => false,
                ],
            ]);

            if (count($item['children']) > 0) {
                $label .= ' <b class="caret caret-menu"></b>';
                $menuOptions = array_merge($menuOptions, $subMenuOptions, [
                    'label' => $label,
                ]);
            }

            $subMenu = $this->factory->createItem($item['label'], $menuOptions);
            $menu->addChild($subMenu);

            if (count($item['children']) > 0) {
                $this->buildSubMenu($subMenu, $item['children']);
            }
        }

        return $menu;
    }

    /**
     * @param string            $id
     * @param array             $parameters
     * @param string|null|false $domain
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
}
