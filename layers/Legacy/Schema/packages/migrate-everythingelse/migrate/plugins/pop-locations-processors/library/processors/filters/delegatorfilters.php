<?php

class PoP_Locations_Module_Processor_CustomDelegatorFilters extends PoP_Module_Processor_CustomDelegatorFiltersBase
{
    public final const MODULE_DELEGATORFILTER_LOCATIONS = 'delegatorfilter-locations';

    public function getComponentsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_DELEGATORFILTER_LOCATIONS],
        );
    }

    public function getInnerSubmodule(array $component)
    {
        $inners = array(
            self::MODULE_DELEGATORFILTER_LOCATIONS => [PoP_Locations_Module_Processor_CustomSimpleFilterInners::class, PoP_Locations_Module_Processor_CustomSimpleFilterInners::MODULE_SIMPLEFILTERINPUTCONTAINER_LOCATIONS],
        );

        if ($inner = $inners[$component[1]] ?? null) {
            return $inner;
        }

        return parent::getInnerSubmodule($component);
    }
}



