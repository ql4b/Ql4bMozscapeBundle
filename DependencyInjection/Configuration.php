<?php

namespace Ql4b\Bundle\MozscapeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('mozscape');
        
        $rootNode
            ->children()
                ->scalarNode('apiBaseUrl')
					->isRequired()
                    ->cannotBeEmpty()
				->end()
                ->scalarNode('accessId')
					->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('secretKey')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
	        ->end();
        
        return $treeBuilder;
    }
}
