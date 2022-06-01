<?php

class PoPTheme_Wassup_SocialNetwork_WebPlatform_PageSectionHooks
{
    public function __construct()
    {
        \PoP\Root\App::addAction(
            'PoP_Module_Processor_CustomTabPanePageSections:get_props_block_initial:addons',
            $this->initModelPropsAddons(...),
            10,
            3
        );
    }

    public function initModelPropsAddons(\PoP\ComponentModel\Component\Component $component, $props_in_array, $processor)
    {
        $props = &$props_in_array[0];
        switch ($component[1]) {
            case PoP_Module_Processor_TabPanes::COMPONENT_PAGESECTION_ADDONS:
                $processor->mergeJsmethodsProp([PoP_SocialNetwork_Module_Processor_Blocks::class, PoP_SocialNetwork_Module_Processor_Blocks::COMPONENT_BLOCK_CONTACTUSER], $props, array('destroyPageOnSuccess'));
                $processor->mergeProp(
                    [PoP_SocialNetwork_Module_Processor_Blocks::class, PoP_SocialNetwork_Module_Processor_Blocks::COMPONENT_BLOCK_CONTACTUSER],
                    $props,
                    'params',
                    array(
                        'data-destroytime' => 3000
                    )
                );
                break;
        }
    }
}

/**
 * Initialization
 */
new PoPTheme_Wassup_SocialNetwork_WebPlatform_PageSectionHooks();
