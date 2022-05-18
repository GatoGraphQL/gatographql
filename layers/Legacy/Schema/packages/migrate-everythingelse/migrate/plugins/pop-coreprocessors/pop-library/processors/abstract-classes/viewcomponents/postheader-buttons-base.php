<?php

abstract class PoP_Module_Processor_PostHeaderViewComponentButtonsBase extends PoP_Module_Processor_PostViewComponentButtonsBase
{
    public function getHeaderSubmodule(array $component): ?array
    {
        if ($this->headerShowUrl($component)) {
            return [PoP_Module_Processor_PostViewComponentHeaders::class, PoP_Module_Processor_PostViewComponentHeaders::MODULE_VIEWCOMPONENT_HEADER_POST_URL];
        }

        return [PoP_Module_Processor_PostViewComponentHeaders::class, PoP_Module_Processor_PostViewComponentHeaders::MODULE_VIEWCOMPONENT_HEADER_POST];
    }
}
