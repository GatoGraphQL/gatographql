<?php

class PoP_LocationPostCategoryLayouts_Module_Processor_MultipleComponents extends PoP_Module_Processor_MultiplesBase
{
    public final const MODULE_MULTICOMPONENT_LOCATIONMAP = 'multicomponent-locationmap';

    public function getComponentsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_MULTICOMPONENT_LOCATIONMAP],
        );
    }

    public function getSubComponents(array $component): array
    {
        $ret = parent::getSubComponents($component);

        switch ($component[1]) {
            case self::MODULE_MULTICOMPONENT_LOCATIONMAP:
                $ret[] = [PoP_Module_Processor_MapStaticImages::class, PoP_Module_Processor_MapStaticImages::MODULE_MAP_STATICIMAGE_USERORPOST];
                break;
        }

        return $ret;
    }

    public function initModelProps(array $component, array &$props): void
    {
        switch ($component[1]) {
            case self::MODULE_MULTICOMPONENT_LOCATIONMAP:
                $this->setProp([PoP_Module_Processor_MapStaticImages::class, PoP_Module_Processor_MapStaticImages::MODULE_MAP_STATICIMAGE_USERORPOST], $props, 'staticmap-size', '480x150');
                break;
        }

        parent::initModelProps($component, $props);
    }
}



