<?php
use PoP\Root\Facades\Translation\TranslationAPIFacade;

class GD_EM_Module_Processor_WidgetMessages extends PoP_Module_Processor_WidgetMessagesBase
{
    public final const COMPONENT_EM_MESSAGE_NOLOCATION = 'em-message-nolocation';

    public function getComponentsToProcess(): array
    {
        return array(
            [self::class, self::COMPONENT_EM_MESSAGE_NOLOCATION],
        );
    }

    public function getMessage(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component[1]) {
            case self::COMPONENT_EM_MESSAGE_NOLOCATION:
                return TranslationAPIFacade::getInstance()->__('No location', 'em-popprocessors');
        }

        return parent::getMessage($component);
    }
}



