<?php

class PoP_Module_Processor_PostAdditionalLayouts extends PoP_Module_Processor_PostAdditionalLayoutsBase
{
    public final const MODULE_LAYOUT_POSTADDITIONAL_MULTILAYOUT_LABEL = 'layout-postadditional-multilayout-label';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_LAYOUT_POSTADDITIONAL_MULTILAYOUT_LABEL],
        );
    }
}



