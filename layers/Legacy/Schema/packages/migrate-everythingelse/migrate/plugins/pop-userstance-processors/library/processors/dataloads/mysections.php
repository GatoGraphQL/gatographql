<?php
use PoP\Root\Facades\Translation\TranslationAPIFacade;
use PoPSchema\Stances\TypeResolvers\ObjectType\StanceObjectTypeResolver;

class UserStance_Module_Processor_MySectionDataloads extends PoP_Module_Processor_MySectionDataloadsBase
{
    public final const MODULE_DATALOAD_MYSTANCES_TABLE_EDIT = 'dataload-mystances-table-edit';
    public final const MODULE_DATALOAD_MYSTANCES_SCROLL_FULLVIEWPREVIEW = 'dataload-mystances-scroll-fullviewpreview';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_DATALOAD_MYSTANCES_TABLE_EDIT],
            [self::class, self::MODULE_DATALOAD_MYSTANCES_SCROLL_FULLVIEWPREVIEW],
        );
    }

    public function getRelevantRoute(array $componentVariation, array &$props): ?string
    {
        return match($componentVariation[1]) {
            self::MODULE_DATALOAD_MYSTANCES_SCROLL_FULLVIEWPREVIEW => POP_USERSTANCE_ROUTE_MYSTANCES,
            self::MODULE_DATALOAD_MYSTANCES_TABLE_EDIT => POP_USERSTANCE_ROUTE_MYSTANCES,
            default => parent::getRelevantRoute($componentVariation, $props),
        };
    }

    public function getInnerSubmodule(array $componentVariation)
    {
        $inner_componentVariations = array(
            self::MODULE_DATALOAD_MYSTANCES_TABLE_EDIT => [UserStance_Module_Processor_Tables::class, UserStance_Module_Processor_Tables::MODULE_TABLE_MYSTANCES],
            self::MODULE_DATALOAD_MYSTANCES_SCROLL_FULLVIEWPREVIEW => [UserStance_Module_Processor_CustomScrolls::class, UserStance_Module_Processor_CustomScrolls::MODULE_SCROLL_MYSTANCES_FULLVIEWPREVIEW],
        );

        return $inner_componentVariations[$componentVariation[1]] ?? null;
    }

    public function getFilterSubmodule(array $componentVariation): ?array
    {
        switch ($componentVariation[1]) {
            case self::MODULE_DATALOAD_MYSTANCES_TABLE_EDIT:
            case self::MODULE_DATALOAD_MYSTANCES_SCROLL_FULLVIEWPREVIEW:
                return [UserStance_Module_Processor_CustomFilters::class, UserStance_Module_Processor_CustomFilters::MODULE_FILTER_MYSTANCES];
        }

        return parent::getFilterSubmodule($componentVariation);
    }

    public function getFormat(array $componentVariation): ?string
    {
        $tables = array(
            [self::class, self::MODULE_DATALOAD_MYSTANCES_TABLE_EDIT],
        );
        $fullviews = array(
            [self::class, self::MODULE_DATALOAD_MYSTANCES_SCROLL_FULLVIEWPREVIEW],
        );
        if (in_array($componentVariation, $tables)) {
            $format = POP_FORMAT_TABLE;
        } elseif (in_array($componentVariation, $fullviews)) {
            $format = POP_FORMAT_FULLVIEW;
        }

        return $format ?? parent::getFormat($componentVariation);
    }

    public function getRelationalTypeResolver(array $componentVariation): ?\PoP\ComponentModel\TypeResolvers\RelationalTypeResolverInterface
    {
        switch ($componentVariation[1]) {
            case self::MODULE_DATALOAD_MYSTANCES_TABLE_EDIT:
            case self::MODULE_DATALOAD_MYSTANCES_SCROLL_FULLVIEWPREVIEW:
                return $this->instanceManager->getInstance(StanceObjectTypeResolver::class);
        }

        return parent::getRelationalTypeResolver($componentVariation);
    }

    public function initModelProps(array $componentVariation, array &$props): void
    {
        switch ($componentVariation[1]) {
            case self::MODULE_DATALOAD_MYSTANCES_TABLE_EDIT:
            case self::MODULE_DATALOAD_MYSTANCES_SCROLL_FULLVIEWPREVIEW:
                $stances = PoP_UserStance_PostNameUtils::getNamesLc();
                $this->setProp([PoP_Module_Processor_DomainFeedbackMessageLayouts::class, PoP_Module_Processor_DomainFeedbackMessageLayouts::MODULE_LAYOUT_FEEDBACKMESSAGE_ITEMLIST], $props, 'pluralname', $stances);
                $this->setProp(
                    [GD_UserLogin_Module_Processor_UserCheckpointMessageLayouts::class, GD_UserLogin_Module_Processor_UserCheckpointMessageLayouts::MODULE_LAYOUT_CHECKPOINTMESSAGE_LOGGEDIN],
                    $props,
                    'action',
                    sprintf(
                        TranslationAPIFacade::getInstance()->__('access your %s', 'poptheme-wassup'),
                        $stances
                    )
                );
                break;
        }
        parent::initModelProps($componentVariation, $props);
    }
}



