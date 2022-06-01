<?php

class PoP_ContentPostLinks_Module_Processor_CustomVerticalSingleSidebarInners extends PoP_Module_Processor_SidebarInnersBase
{
    public final const COMPONENT_VERTICALSIDEBARINNER_SINGLE_LINK = 'vertical-sidebarinner-single-link';

    public function getComponentsToProcess(): array
    {
        return array(
            [self::class, self::COMPONENT_VERTICALSIDEBARINNER_SINGLE_LINK],
        );
    }

    public function getLayoutSubcomponents(\PoP\ComponentModel\Component\Component $component)
    {
        $ret = parent::getLayoutSubcomponents($component);

        switch ($component[1]) {
            case self::COMPONENT_VERTICALSIDEBARINNER_SINGLE_LINK:
                $ret = array_merge(
                    $ret,
                    PoP_ContentPostLinks_FullViewSidebarSettings::getSidebarSubcomponents(GD_SIDEBARSECTION_POSTLINK)
                );
                break;
        }

        return $ret;
    }
}



