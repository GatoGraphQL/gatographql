<?php
use PoP\Root\Facades\Translation\TranslationAPIFacade;

class GD_QT_Module_Processor_SelectFormInputs extends PoP_Module_Processor_SelectFormInputsBase
{
    public final const MODULE_QT_FORMINPUT_LANGUAGE = 'qt-forminput-language';

    public function getComponentsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_QT_FORMINPUT_LANGUAGE],
        );
    }

    public function getLabelText(array $component, array &$props)
    {
        switch ($component[1]) {
            case self::MODULE_QT_FORMINPUT_LANGUAGE:
                return TranslationAPIFacade::getInstance()->__('Language', 'poptheme-wassup');
        }
        
        return parent::getLabelText($component, $props);
    }

    public function getInputClass(array $component): string
    {
        switch ($component[1]) {
            case self::MODULE_QT_FORMINPUT_LANGUAGE:
                return GD_QT_FormInput_Languages::class;
        }
        
        return parent::getInputClass($component);
    }
}



