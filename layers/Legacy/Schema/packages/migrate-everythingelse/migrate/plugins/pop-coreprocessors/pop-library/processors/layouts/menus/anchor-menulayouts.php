<?php

class PoP_Module_Processor_AnchorMenuLayouts extends PoP_Module_Processor_AnchorMenuLayoutsBase
{
    public final const COMPONENT_LAYOUT_MENU_BUTTON = 'layout-menu-button';

    public function getComponentsToProcess(): array
    {
        return array(
            [self::class, self::COMPONENT_LAYOUT_MENU_BUTTON],
        );
    }

    public function getItemClass(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        switch ($component[1]) {
            case self::COMPONENT_LAYOUT_MENU_BUTTON:
                return 'btn btn-default btn-block';
        }
    
        return parent::getItemClass($component, $props);
    }
}


