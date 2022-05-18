<?php

class PoP_Module_Processor_ControlMulticomponents extends PoP_Module_Processor_MultiplesBase
{
    public final const MODULE_MULTICOMPONENT_ANCHORCONTROL_TOGGLETABS = 'multicomponent-anchorcontrol-toggletabs';

    public function getComponentsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_MULTICOMPONENT_ANCHORCONTROL_TOGGLETABS],
        );
    }

    public function getSubComponents(array $component): array
    {
        $ret = parent::getSubComponents($component);

        switch ($component[1]) {
            case self::MODULE_MULTICOMPONENT_ANCHORCONTROL_TOGGLETABS:
                $ret[] = [GD_Wassup_Module_Processor_AnchorControls::class, GD_Wassup_Module_Processor_AnchorControls::MODULE_ANCHORCONTROL_TOGGLETABS];
                $ret[] = [GD_Wassup_Module_Processor_AnchorControls::class, GD_Wassup_Module_Processor_AnchorControls::MODULE_ANCHORCONTROL_TOGGLETABSXS];
                break;
        }

        return $ret;
    }
}



