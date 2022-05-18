<?php

define('POP_MODULEFILTER_USERSTATE', 'userstate');

use PoP\ComponentModel\Facades\ComponentProcessors\ComponentProcessorManagerFacade;
use PoP\ComponentModel\ComponentFilters\AbstractComponentFilter;

class PoP_ComponentFilter_UserState extends AbstractComponentFilter
{
    public function getName(): string
    {
        return POP_MODULEFILTER_USERSTATE;
    }

    public function excludeModule(array $module, array &$props): bool
    {

        // Exclude if it has no user state
        $componentprocessor_manager = ComponentProcessorManagerFacade::getInstance();
        $processor = $componentprocessor_manager->getProcessor($module);
        $processoruserstate = PoP_UserStateModuleDecoratorProcessorManagerFactory::getInstance()->getProcessorDecorator($processor);
        return !$processoruserstate->requiresUserState($module, $props);
    }
}

/**
 * Initialization
 */
new PoP_ComponentFilter_UserState();
