<?php

class PoP_Module_Processor_LocationSelectableTypeaheadAlertFormComponents extends PoP_Module_Processor_LocationSelectableTypeaheadAlertFormComponentsBase
{
    public final const MODULE_FORMCOMPONENT_SELECTABLETYPEAHEADALERT_LOCATIONS = 'formcomponent-selectabletypeaheadalert-locations';
    public final const MODULE_FORMCOMPONENT_SELECTABLETYPEAHEADALERT_LOCATION = 'formcomponent-selectabletypeaheadalert-location';

    public function getComponentsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_FORMCOMPONENT_SELECTABLETYPEAHEADALERT_LOCATIONS],
            [self::class, self::MODULE_FORMCOMPONENT_SELECTABLETYPEAHEADALERT_LOCATION],
        );
    }
    
    public function getHiddeninputModule(array $component)
    {
        switch ($component[1]) {
            case self::MODULE_FORMCOMPONENT_SELECTABLETYPEAHEADALERT_LOCATIONS:
                return [GD_Processor_SelectableLocationHiddenInputFormInputs::class, GD_Processor_SelectableLocationHiddenInputFormInputs::MODULE_FORMINPUT_HIDDENINPUT_SELECTABLELAYOUTLOCATIONS];

            case self::MODULE_FORMCOMPONENT_SELECTABLETYPEAHEADALERT_LOCATION:
                return [GD_Processor_SelectableLocationHiddenInputFormInputs::class, GD_Processor_SelectableLocationHiddenInputFormInputs::MODULE_FORMINPUT_HIDDENINPUT_SELECTABLELAYOUTLOCATION];
        }

        return parent::getHiddeninputModule($component);
    }

    public function isMultiple(array $component): bool
    {
        switch ($component[1]) {
            case self::MODULE_FORMCOMPONENT_SELECTABLETYPEAHEADALERT_LOCATIONS:
                return true;
        }

        return parent::isMultiple($component);
    }
}



