<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\Admin\Tables;

use GraphQLAPI\GraphQLAPI\Admin\Tables\ModuleListTable as UpstreamModuleListTable;
use GraphQLAPI\GraphQLAPI\ConditionalOnContext\PROPluginInformation\ModuleResolvers\PROPseudoModuleResolverInterface;
use GraphQLAPI\GraphQLAPI\Facades\Registries\ModuleRegistryFacade;
use GraphQLAPI\GraphQLAPI\Module;
use GraphQLAPI\GraphQLAPI\ModuleConfiguration;
use PoP\ComponentModel\App;

class ModuleListTable extends UpstreamModuleListTable
{
    /**
     * Return all the items to display on the table
     *
     * @return array<array<string,mixed>> Each item is an array of prop => value
     */
    public function getAllItems(): array
    {
        $items = parent::getAllItems();
        $moduleRegistry = ModuleRegistryFacade::getInstance();
        foreach ($items as &$item) {
            $module = $item['module'];
            $moduleResolver = $moduleRegistry->getModuleResolver($module);
            if (!($moduleResolver instanceof PROPseudoModuleResolverInterface)) {
                continue;
            }
            $item['is-pro'] = true;
        }
        return $items;
    }

    /**
     * @param array<string,string> $item an array of DB data
     * @return array<string,string>
     */
    protected function getColumnActions(array $item): array
    {
        if ($item['is-pro']) {
            /** @var ModuleConfiguration */
            $moduleConfiguration = App::getModule(Module::class)->getConfiguration();
            // Remove all previous items, only keep "Go PRO"
            $actions = [];
            $actions['go-pro'] = \sprintf(
                '<a href="%s" target="%s">%s</a>',
                $moduleConfiguration->getPROPluginWebsiteURL(),
                '_blank',
                \__('Go PRO to unlock! 🔓', 'graphql-api')
            );
            return $actions;
        }
        return parent::getColumnActions($item);
    }
}
