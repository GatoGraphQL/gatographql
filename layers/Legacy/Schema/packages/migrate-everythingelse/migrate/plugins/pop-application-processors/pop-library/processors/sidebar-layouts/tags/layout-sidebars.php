<?php

class PoP_Module_Processor_CustomTagLayoutSidebars extends PoP_Module_Processor_SidebarsBase
{
    public final const MODULE_LAYOUT_TAGSIDEBAR_VERTICAL = 'layout-tagsidebar-vertical';
    public final const MODULE_LAYOUT_TAGSIDEBAR_HORIZONTAL = 'layout-tagsidebar-horizontal';
    public final const MODULE_LAYOUT_TAGSIDEBAR_COMPACTHORIZONTAL = 'layout-tagsidebar-compacthorizontal';

    public function getComponentsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_LAYOUT_TAGSIDEBAR_VERTICAL],
            [self::class, self::MODULE_LAYOUT_TAGSIDEBAR_HORIZONTAL],
            [self::class, self::MODULE_LAYOUT_TAGSIDEBAR_COMPACTHORIZONTAL],
        );
    }

    public function getInnerSubmodule(array $component)
    {
        $sidebarinners = array(
            self::MODULE_LAYOUT_TAGSIDEBAR_VERTICAL => [PoP_Module_Processor_CustomTagLayoutSidebarInners::class, PoP_Module_Processor_CustomTagLayoutSidebarInners::MODULE_LAYOUT_TAGSIDEBARINNER_VERTICAL],
            self::MODULE_LAYOUT_TAGSIDEBAR_HORIZONTAL => [PoP_Module_Processor_CustomTagLayoutSidebarInners::class, PoP_Module_Processor_CustomTagLayoutSidebarInners::MODULE_LAYOUT_TAGSIDEBARINNER_HORIZONTAL],
            self::MODULE_LAYOUT_TAGSIDEBAR_COMPACTHORIZONTAL => [PoP_Module_Processor_CustomTagLayoutSidebarInners::class, PoP_Module_Processor_CustomTagLayoutSidebarInners::MODULE_LAYOUT_TAGSIDEBARINNER_COMPACTHORIZONTAL],
        );

        if ($inner = $sidebarinners[$component[1]] ?? null) {
            return $inner;
        }

        return parent::getInnerSubmodule($component);
    }

    public function initModelProps(array $component, array &$props): void
    {
        switch ($component[1]) {
            case self::MODULE_LAYOUT_TAGSIDEBAR_VERTICAL:
                $this->appendProp($component, $props, 'class', 'vertical');
                break;

            case self::MODULE_LAYOUT_TAGSIDEBAR_HORIZONTAL:
            case self::MODULE_LAYOUT_TAGSIDEBAR_COMPACTHORIZONTAL:
                $this->appendProp($component, $props, 'class', 'horizontal');
                break;
        }

        parent::initModelProps($component, $props);
    }
}



