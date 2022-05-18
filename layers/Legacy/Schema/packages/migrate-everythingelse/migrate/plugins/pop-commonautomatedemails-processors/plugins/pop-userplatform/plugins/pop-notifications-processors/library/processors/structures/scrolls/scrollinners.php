<?php

class GD_AAL_Module_Processor_AutomatedEmailsScrollInners extends PoP_Module_Processor_ScrollInnersBase
{
    public final const MODULE_SCROLLINNER_AUTOMATEDEMAILS_NOTIFICATIONS_DETAILS = 'scrollinner-automatedemails-notifications-details';
    public final const MODULE_SCROLLINNER_AUTOMATEDEMAILS_NOTIFICATIONS_LIST = 'scrollinner-automatedemails-notifications-list';

    public function getComponentsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_SCROLLINNER_AUTOMATEDEMAILS_NOTIFICATIONS_DETAILS],
            [self::class, self::MODULE_SCROLLINNER_AUTOMATEDEMAILS_NOTIFICATIONS_LIST],
        );
    }

    public function getLayoutGrid(array $component, array &$props)
    {
        switch ($component[1]) {
            case self::MODULE_SCROLLINNER_AUTOMATEDEMAILS_NOTIFICATIONS_DETAILS:
            case self::MODULE_SCROLLINNER_AUTOMATEDEMAILS_NOTIFICATIONS_LIST:
                return array(
                    'row-items' => 1,
                    'class' => 'col-sm-12'
                );
        }

        return parent::getLayoutGrid($component, $props);
    }

    public function getLayoutSubmodules(array $component)
    {
        $ret = parent::getLayoutSubmodules($component);

        $layouts = array(
            self::MODULE_SCROLLINNER_AUTOMATEDEMAILS_NOTIFICATIONS_DETAILS => [PoP_Module_Processor_AutomatedEmailsPreviewNotificationLayouts::class, PoP_Module_Processor_AutomatedEmailsPreviewNotificationLayouts::MODULE_LAYOUT_AUTOMATEDEMAILS_PREVIEWNOTIFICATION_DETAILS],
            self::MODULE_SCROLLINNER_AUTOMATEDEMAILS_NOTIFICATIONS_LIST => [PoP_Module_Processor_AutomatedEmailsPreviewNotificationLayouts::class, PoP_Module_Processor_AutomatedEmailsPreviewNotificationLayouts::MODULE_LAYOUT_AUTOMATEDEMAILS_PREVIEWNOTIFICATION_LIST],
        );
        if ($layout = $layouts[$component[1]] ?? null) {
            $ret[] = $layout;
        }

        return $ret;
    }
}


