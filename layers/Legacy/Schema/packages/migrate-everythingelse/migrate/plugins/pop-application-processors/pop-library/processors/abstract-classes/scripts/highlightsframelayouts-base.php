<?php

abstract class PoP_Module_Processor_HighlightReferencesScriptFrameLayoutsBase extends PoP_Module_Processor_ScriptFrameLayoutsBase
{
    public function doAppend(array $component)
    {
        return true;
    }

    public function getScriptSubmodule(array $component)
    {
        return $this->doAppend($component) ? 
        	[Wassup_Module_Processor_ScriptsLayouts::class, Wassup_Module_Processor_ScriptsLayouts::MODULE_SCRIPT_HIGHLIGHTS] : 
        	[Wassup_Module_Processor_ScriptsLayouts::class, Wassup_Module_Processor_ScriptsLayouts::MODULE_SCRIPT_HIGHLIGHTSEMPTY];
    }
}
