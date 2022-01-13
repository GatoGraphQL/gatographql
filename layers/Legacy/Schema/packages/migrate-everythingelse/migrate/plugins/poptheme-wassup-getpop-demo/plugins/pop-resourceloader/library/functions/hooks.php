<?php

class GetPoPDemo_ResourceLoader_Hooks
{
    public function __construct()
    {
        \PoP\Root\App::getHookManager()->addFilter(
            'PoPTheme_Wassup_ResourceLoaderProcessor_Hooks:css-resources:collapse-hometop',
            array($this, 'getCollapseHometopModule')
        );
    }

    public function getCollapseHometopModule(?array $module)
    {
        return [GetPoPDemo_Module_Processor_TopLevelCollapseComponents::class, GetPoPDemo_Module_Processor_TopLevelCollapseComponents::MODULE_GETPOPDEMO_COLLAPSECOMPONENT_HOMETOP];
    }
}

/**
 * Initialization
 */
new GetPoPDemo_ResourceLoader_Hooks();
