<?php
use PoP\Root\Facades\Translation\TranslationAPIFacade;

class GD_UserCommunities_Module_Processor_TypeaheadTextFormInputs extends PoP_Module_Processor_TextFormInputsBase
{
    public final const MODULE_FORMINPUT_TEXT_TYPEAHEADCOMMUNITIES = 'forminput-text-typeaheadcommunities';

    public function getComponentsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_FORMINPUT_TEXT_TYPEAHEADCOMMUNITIES],
        );
    }

    public function getLabelText(array $component, array &$props)
    {
        switch ($component[1]) {
            case self::MODULE_FORMINPUT_TEXT_TYPEAHEADCOMMUNITIES:
                return TranslationAPIFacade::getInstance()->__('Community', 'ure-popprocessors');
        }
        
        return parent::getLabelText($component, $props);
    }
}



