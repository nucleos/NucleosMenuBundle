<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\MenuBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\NodeInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('nucleos_menu');

        $rootNode = $treeBuilder->getRootNode();

        $this->addMenuSection($rootNode);

        return $treeBuilder;
    }

    private function addMenuSection(ArrayNodeDefinition $node): void
    {
        $menuNode = $node
            ->children()
                ->arrayNode('groups')
                    ->useAttributeAsKey('id')
                    ->prototype('array')
                        ->fixXmlConfig('attribute')
                        ->fixXmlConfig('item')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('name')->defaultNull()->end()
                            ->arrayNode('attributes')
                                 ->useAttributeAsKey('id')
                                 ->defaultValue([])
                                 ->prototype('scalar')->end()
                            ->end()
                            ->arrayNode('items')
                                ->useAttributeAsKey('id')
                                ->defaultValue([])
                                ->prototype('array')
        ;

        $this->buildPathNode($menuNode);

        $menuNode
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    private function buildPathNode(NodeDefinition $node): void
    {
        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('label')->defaultNull()->end()
                ->scalarNode('label_catalogue')->defaultFalse()->end()
                ->scalarNode('icon')->defaultNull()->end()
                ->scalarNode('class')->defaultNull()->end()
                ->scalarNode('route')->defaultNull()->end()
                ->arrayNode('routeParams')
                    ->defaultValue([])
                    ->useAttributeAsKey('param')
                    ->prototype('scalar')->end()
                    ->validate()->ifTrue(static function ($element): bool {
                        return !\is_array($element);
                    })->thenInvalid('The routeParams element must be an array.')->end()
                ->end()
                ->variableNode('children')
                    ->defaultValue([])
                    ->validate()->ifTrue(static function ($element): bool {
                        return !\is_array($element);
                    })->thenInvalid('The children element must be an array.')->end()
                    ->validate()->always(function ($children) {
                        array_walk($children, [$this, 'evaluateChildren']);

                        return $children;
                    })->end()
                ->end()
            ->end()
            ;
    }

    private function evaluateChildren(array &$child, string $name): void
    {
        $child = $this->getPathNode($name)->finalize($child);
    }

    private function getPathNode(string $name = ''): NodeInterface
    {
        $treeBuilder = new TreeBuilder($name);

        $definition = $treeBuilder->getRootNode();

        $this->buildPathNode($definition);

        return $definition->getNode(true);
    }
}
