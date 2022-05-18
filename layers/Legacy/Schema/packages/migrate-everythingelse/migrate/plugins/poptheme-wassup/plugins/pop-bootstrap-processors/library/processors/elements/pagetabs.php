<?php
use PoP\ComponentRouting\Facades\ComponentRoutingProcessorManagerFacade;
use PoP\SPA\Modules\PageInterface;

class PoP_Module_Processor_PageTabs extends PoP_Module_Processor_PageTabPageSectionsBase implements PageInterface
{
    public final const MODULE_PAGE_ADDONTABS = 'page-addontabs';
    public final const MODULE_PAGE_BODYTABS = 'page-bodytabs';
    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_PAGE_ADDONTABS],
            [self::class, self::MODULE_PAGE_BODYTABS],
        );
    }

    public function getInnerSubmodules(array $componentVariation): array
    {
        $ret = parent::getInnerSubmodules($componentVariation);

        $pop_componentVariation_componentroutingprocessor_manager = ComponentRoutingProcessorManagerFacade::getInstance();

        switch ($componentVariation[1]) {
            case self::MODULE_PAGE_ADDONTABS:
            case self::MODULE_PAGE_BODYTABS:
                if ($tab_componentVariation = $pop_componentVariation_componentroutingprocessor_manager->getRoutingComponentByMostAllMatchingStateProperties(POP_PAGEMODULEGROUP_PAGESECTION_TAB)) {
                    $ret[] = $tab_componentVariation;
                }
                break;
        }

        return $ret;
    }

    public function getBtnClass(array $componentVariation, array &$props)
    {
        switch ($componentVariation[1]) {
            case self::MODULE_PAGE_ADDONTABS:
                return 'btn btn-warning btn-sm';

            case self::MODULE_PAGE_BODYTABS:
                return 'btn btn-inverse btn-sm';
        }

        return parent::getBtnClass($componentVariation, $props);
    }
}



