<?php

class PoPTheme_Wassup_EM_AE_Module_Processor_SimpleViewPreviewPostLayouts extends PoP_Module_Processor_BareSimpleViewPreviewPostLayoutsBase
{
    public final const MODULE_LAYOUT_AUTOMATEDEMAILS_PREVIEWPOST_EVENT_SIMPLEVIEW = 'layout-automatedemails-previewpost-event-simpleview';
    public function getComponentsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_LAYOUT_AUTOMATEDEMAILS_PREVIEWPOST_EVENT_SIMPLEVIEW],
        );
    }


    public function getAuthorModule(array $component)
    {
        switch ($component[1]) {
            case self::MODULE_LAYOUT_AUTOMATEDEMAILS_PREVIEWPOST_EVENT_SIMPLEVIEW:
                return [PoP_Module_Processor_PostAuthorNameLayouts::class, PoP_Module_Processor_PostAuthorNameLayouts::MODULE_LAYOUTPOST_AUTHORNAME];
        }

        return parent::getAuthorModule($component);
    }

    public function getAbovecontentSubmodules(array $component)
    {
        $ret = parent::getAbovecontentSubmodules($component);

        switch ($component[1]) {
            case self::MODULE_LAYOUT_AUTOMATEDEMAILS_PREVIEWPOST_EVENT_SIMPLEVIEW:
                $ret[] = [GD_EM_Module_Processor_EventMultipleComponents::class, GD_EM_Module_Processor_EventMultipleComponents::MODULE_MULTICOMPONENT_EVENT_DATELOCATION];
                break;
        }

        return $ret;
    }

    public function getAftercontentSubmodules(array $component)
    {
        $ret = parent::getAftercontentSubmodules($component);

        switch ($component[1]) {
            case self::MODULE_LAYOUT_AUTOMATEDEMAILS_PREVIEWPOST_EVENT_SIMPLEVIEW:
                $ret[] = [PoPTheme_Wassup_EM_AE_Module_Processor_QuicklinkGroups::class, PoPTheme_Wassup_EM_AE_Module_Processor_QuicklinkGroups::MODULE_QUICKLINKGROUP_EVENTBOTTOM];
                break;
        }

        return $ret;
    }
}


