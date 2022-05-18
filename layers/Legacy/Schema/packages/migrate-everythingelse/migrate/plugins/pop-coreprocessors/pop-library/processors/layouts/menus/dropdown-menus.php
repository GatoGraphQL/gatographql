<?php

class PoP_Module_Processor_DropdownMenuLayouts extends PoP_Module_Processor_DropdownMenuLayoutsBase
{
    public final const MODULE_LAYOUT_MENU_DROPDOWN = 'layout-menu-dropdown';

    public function getComponentsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_LAYOUT_MENU_DROPDOWN],
        );
    }
}



