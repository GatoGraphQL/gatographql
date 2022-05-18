<?php

class PoP_Application_Module_Processor_CommentTriggerLayoutFormComponentValues extends PoP_Module_Processor_CommentTriggerLayoutFormComponentValuesBase
{
    public final const MODULE_FORMCOMPONENT_CARD_COMMENT = 'forminput-comment-card';

    public function getComponentsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_FORMCOMPONENT_CARD_COMMENT],
        );
    }

    public function getTriggerSubmodule(array $component): ?array
    {
        switch ($component[1]) {
            case self::MODULE_FORMCOMPONENT_CARD_COMMENT:
                return [PoP_Module_Processor_CommentHiddenInputAlertFormComponents::class, PoP_Module_Processor_CommentHiddenInputAlertFormComponents::MODULE_FORMCOMPONENT_HIDDENINPUTALERT_LAYOUTCOMMENT];
        }

        return parent::getTriggerSubmodule($component);
    }

    public function getDbobjectField(array $component): ?string
    {
        switch ($component[1]) {
            case self::MODULE_FORMCOMPONENT_CARD_COMMENT:
                return 'self';
        }

        return parent::getDbobjectField($component);
    }
}



