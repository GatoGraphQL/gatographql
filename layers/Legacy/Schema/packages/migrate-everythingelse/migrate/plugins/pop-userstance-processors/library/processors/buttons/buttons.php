<?php
use PoP\Root\Facades\Translation\TranslationAPIFacade;

class UserStance_Module_Processor_Buttons extends PoP_Module_Processor_ButtonsBase
{
    public final const MODULE_BUTTON_STANCEEDIT = 'button-stanceedit';
    public final const MODULE_BUTTON_STANCEVIEW = 'button-stanceview';
    public final const MODULE_BUTTON_POSTSTANCES_PRO = 'button-poststances-pro';
    public final const MODULE_BUTTON_POSTSTANCES_NEUTRAL = 'button-poststances-neutral';
    public final const MODULE_BUTTON_POSTSTANCES_AGAINST = 'button-poststances-against';

    public function getComponentsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_BUTTON_STANCEEDIT],
            [self::class, self::MODULE_BUTTON_STANCEVIEW],
            [self::class, self::MODULE_BUTTON_POSTSTANCES_PRO],
            [self::class, self::MODULE_BUTTON_POSTSTANCES_NEUTRAL],
            [self::class, self::MODULE_BUTTON_POSTSTANCES_AGAINST],
        );
    }

    public function getButtoninnerSubmodule(array $component)
    {
        $buttoninners = array(
            self::MODULE_BUTTON_STANCEEDIT => [PoP_ContentCreation_Module_Processor_ButtonInners::class, PoP_ContentCreation_Module_Processor_ButtonInners::MODULE_BUTTONINNER_POSTEDIT],
            self::MODULE_BUTTON_STANCEVIEW => [PoP_ContentCreation_Module_Processor_ButtonInners::class, PoP_ContentCreation_Module_Processor_ButtonInners::MODULE_BUTTONINNER_POSTVIEW],
            self::MODULE_BUTTON_POSTSTANCES_PRO => [UserStance_Module_Processor_ButtonInners::class, UserStance_Module_Processor_ButtonInners::MODULE_BUTTONINNER_POSTSTANCE_PRO],
            self::MODULE_BUTTON_POSTSTANCES_NEUTRAL => [UserStance_Module_Processor_ButtonInners::class, UserStance_Module_Processor_ButtonInners::MODULE_BUTTONINNER_POSTSTANCE_NEUTRAL],
            self::MODULE_BUTTON_POSTSTANCES_AGAINST => [UserStance_Module_Processor_ButtonInners::class, UserStance_Module_Processor_ButtonInners::MODULE_BUTTONINNER_POSTSTANCE_AGAINST],
        );
        if ($buttoninner = $buttoninners[$component[1]] ?? null) {
            return $buttoninner;
        }

        return parent::getButtoninnerSubmodule($component);
    }

    public function getUrlField(array $component)
    {
        $fields = array(
            self::MODULE_BUTTON_STANCEEDIT => 'editURL',
            self::MODULE_BUTTON_POSTSTANCES_PRO => 'postStancesProURL',
            self::MODULE_BUTTON_POSTSTANCES_NEUTRAL => 'postStancesNeutralURL',
            self::MODULE_BUTTON_POSTSTANCES_AGAINST => 'postStancesAgainstURL',
        );
        if ($field = $fields[$component[1]] ?? null) {
            return $field;
        }

        return parent::getUrlField($component);
    }

    public function getTitle(array $component, array &$props)
    {
        $titles = array(
            self::MODULE_BUTTON_STANCEEDIT => TranslationAPIFacade::getInstance()->__('Edit', 'pop-userstance-processors'),
            self::MODULE_BUTTON_STANCEVIEW => TranslationAPIFacade::getInstance()->__('View', 'pop-userstance-processors'),
            self::MODULE_BUTTON_POSTSTANCES_PRO => TranslationAPIFacade::getInstance()->__('Pro', 'pop-userstance-processors'),
            self::MODULE_BUTTON_POSTSTANCES_NEUTRAL => TranslationAPIFacade::getInstance()->__('Neutral', 'pop-userstance-processors'),
            self::MODULE_BUTTON_POSTSTANCES_AGAINST => TranslationAPIFacade::getInstance()->__('Against', 'pop-userstance-processors'),
        );
        if ($title = $titles[$component[1]] ?? null) {
            return $title;
        }

        return parent::getTitle($component, $props);
    }

    public function getLinktarget(array $component, array &$props)
    {
        switch ($component[1]) {
            case self::MODULE_BUTTON_STANCEEDIT:
                return POP_TARGET_ADDONS;

            case self::MODULE_BUTTON_POSTSTANCES_PRO:
            case self::MODULE_BUTTON_POSTSTANCES_NEUTRAL:
            case self::MODULE_BUTTON_POSTSTANCES_AGAINST:
                return POP_TARGET_QUICKVIEW;
        }

        return parent::getLinktarget($component, $props);
    }

    public function getBtnClass(array $component, array &$props)
    {
        $ret = parent::getBtnClass($component, $props);

        switch ($component[1]) {
            case self::MODULE_BUTTON_STANCEVIEW:
            case self::MODULE_BUTTON_STANCEEDIT:
                $ret .= ' btn btn-xs btn-default';
                break;

            case self::MODULE_BUTTON_POSTSTANCES_PRO:
            case self::MODULE_BUTTON_POSTSTANCES_NEUTRAL:
            case self::MODULE_BUTTON_POSTSTANCES_AGAINST:
                $ret .= ' btn btn-link';
                break;
        }

        return $ret;
    }
}


