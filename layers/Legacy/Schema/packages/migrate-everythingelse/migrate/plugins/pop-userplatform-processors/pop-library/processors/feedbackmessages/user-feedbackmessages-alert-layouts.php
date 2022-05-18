<?php

class PoP_Module_Processor_UserFeedbackMessageAlertLayouts extends PoP_Module_Processor_FeedbackMessageAlertLayoutsBase
{
    public final const MODULE_LAYOUT_FEEDBACKMESSAGEALERT_MYPREFERENCES = 'layout-feedbackmessagealert-mypreferences';

    public function getComponentsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_LAYOUT_FEEDBACKMESSAGEALERT_MYPREFERENCES],
        );
    }

    public function getLayoutSubmodule(array $component)
    {
        $layouts = array(
            self::MODULE_LAYOUT_FEEDBACKMESSAGEALERT_MYPREFERENCES => [PoP_Module_Processor_UserFeedbackMessageLayouts::class, PoP_Module_Processor_UserFeedbackMessageLayouts::MODULE_LAYOUT_FEEDBACKMESSAGE_MYPREFERENCES],
        );

        if ($layout = $layouts[$component[1]] ?? null) {
            return $layout;
        }

        return parent::getLayoutSubmodule($component);
    }
}



