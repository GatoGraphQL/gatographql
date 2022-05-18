<?php

class PoP_UserStance_Processor_HiddenInputFormInputs extends PoP_Module_Processor_HiddenInputFormInputsBase
{
    public final const MODULE_FORMINPUT_HIDDENINPUT_STANCETARGET = 'forminput-hiddeninput-stancetarget';

    public function getComponentsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_FORMINPUT_HIDDENINPUT_STANCETARGET],
        );
    }

    public function getName(array $component): string
    {
        switch ($component[1]) {
            case self::MODULE_FORMINPUT_HIDDENINPUT_STANCETARGET:
                return POP_INPUTNAME_STANCETARGET;
        }

        return parent::getName($component);
    }
}
