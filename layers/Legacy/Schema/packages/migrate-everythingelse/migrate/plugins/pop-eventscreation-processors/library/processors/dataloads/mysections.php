<?php
use PoPCMSSchema\Events\ComponentProcessors\PastEventComponentProcessorTrait;
use PoPCMSSchema\Events\TypeResolvers\ObjectType\EventObjectTypeResolver;

class PoP_EventsCreation_Module_Processor_MySectionDataloads extends PoP_EventsCreation_Module_Processor_MySectionDataloadsBase
{
    use PastEventComponentProcessorTrait;

    public final const MODULE_DATALOAD_MYEVENTS_TABLE_EDIT = 'dataload-myevents-table-edit';
    public final const MODULE_DATALOAD_MYPASTEVENTS_TABLE_EDIT = 'dataload-mypastevents-table-edit';
    public final const MODULE_DATALOAD_MYEVENTS_SCROLL_SIMPLEVIEWPREVIEW = 'dataload-myevents-scroll-simpleviewpreview';
    public final const MODULE_DATALOAD_MYPASTEVENTS_SCROLL_SIMPLEVIEWPREVIEW = 'dataload-mypastevents-scroll-simpleviewpreview';
    public final const MODULE_DATALOAD_MYEVENTS_SCROLL_FULLVIEWPREVIEW = 'dataload-myevents-scroll-fullviewpreview';
    public final const MODULE_DATALOAD_MYPASTEVENTS_SCROLL_FULLVIEWPREVIEW = 'dataload-mypastevents-scroll-fullviewpreview';

    public function getComponentsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_DATALOAD_MYEVENTS_TABLE_EDIT],
            [self::class, self::MODULE_DATALOAD_MYPASTEVENTS_TABLE_EDIT],
            [self::class, self::MODULE_DATALOAD_MYEVENTS_SCROLL_SIMPLEVIEWPREVIEW],
            [self::class, self::MODULE_DATALOAD_MYPASTEVENTS_SCROLL_SIMPLEVIEWPREVIEW],
            [self::class, self::MODULE_DATALOAD_MYEVENTS_SCROLL_FULLVIEWPREVIEW],
            [self::class, self::MODULE_DATALOAD_MYPASTEVENTS_SCROLL_FULLVIEWPREVIEW],
        );
    }

    public function getRelevantRoute(array $component, array &$props): ?string
    {
        return match($component[1]) {
            self::MODULE_DATALOAD_MYEVENTS_SCROLL_FULLVIEWPREVIEW => POP_EVENTSCREATION_ROUTE_MYEVENTS,
            self::MODULE_DATALOAD_MYEVENTS_SCROLL_SIMPLEVIEWPREVIEW => POP_EVENTSCREATION_ROUTE_MYEVENTS,
            self::MODULE_DATALOAD_MYEVENTS_TABLE_EDIT => POP_EVENTSCREATION_ROUTE_MYEVENTS,
            self::MODULE_DATALOAD_MYPASTEVENTS_SCROLL_FULLVIEWPREVIEW => POP_EVENTSCREATION_ROUTE_MYPASTEVENTS,
            self::MODULE_DATALOAD_MYPASTEVENTS_SCROLL_SIMPLEVIEWPREVIEW => POP_EVENTSCREATION_ROUTE_MYPASTEVENTS,
            self::MODULE_DATALOAD_MYPASTEVENTS_TABLE_EDIT => POP_EVENTSCREATION_ROUTE_MYPASTEVENTS,
            default => parent::getRelevantRoute($component, $props),
        };
    }

    public function getInnerSubmodule(array $component)
    {
        $inner_components = array(

            /*********************************************
             * My Content Tables
             *********************************************/
            self::MODULE_DATALOAD_MYEVENTS_TABLE_EDIT => [GD_EM_Module_Processor_Tables::class, GD_EM_Module_Processor_Tables::MODULE_TABLE_MYEVENTS],
            self::MODULE_DATALOAD_MYPASTEVENTS_TABLE_EDIT => [GD_EM_Module_Processor_Tables::class, GD_EM_Module_Processor_Tables::MODULE_TABLE_MYPASTEVENTS],

            /*********************************************
             * My Content Full Post Previews
             *********************************************/
            self::MODULE_DATALOAD_MYEVENTS_SCROLL_SIMPLEVIEWPREVIEW => [PoP_EventsCreation_Module_Processor_CustomScrolls::class, PoP_EventsCreation_Module_Processor_CustomScrolls::MODULE_SCROLL_MYEVENTS_SIMPLEVIEWPREVIEW],
            self::MODULE_DATALOAD_MYPASTEVENTS_SCROLL_SIMPLEVIEWPREVIEW => [PoP_EventsCreation_Module_Processor_CustomScrolls::class, PoP_EventsCreation_Module_Processor_CustomScrolls::MODULE_SCROLL_MYPASTEVENTS_SIMPLEVIEWPREVIEW],

            self::MODULE_DATALOAD_MYEVENTS_SCROLL_FULLVIEWPREVIEW => [PoP_EventsCreation_Module_Processor_CustomScrolls::class, PoP_EventsCreation_Module_Processor_CustomScrolls::MODULE_SCROLL_MYEVENTS_FULLVIEWPREVIEW],
            self::MODULE_DATALOAD_MYPASTEVENTS_SCROLL_FULLVIEWPREVIEW => [PoP_EventsCreation_Module_Processor_CustomScrolls::class, PoP_EventsCreation_Module_Processor_CustomScrolls::MODULE_SCROLL_MYPASTEVENTS_FULLVIEWPREVIEW],
        );

        return $inner_components[$component[1]] ?? null;
    }

    public function getFilterSubmodule(array $component): ?array
    {
        switch ($component[1]) {
            case self::MODULE_DATALOAD_MYEVENTS_TABLE_EDIT:
            case self::MODULE_DATALOAD_MYEVENTS_SCROLL_SIMPLEVIEWPREVIEW:
            case self::MODULE_DATALOAD_MYEVENTS_SCROLL_FULLVIEWPREVIEW:
            case self::MODULE_DATALOAD_MYPASTEVENTS_TABLE_EDIT:
            case self::MODULE_DATALOAD_MYPASTEVENTS_SCROLL_SIMPLEVIEWPREVIEW:
            case self::MODULE_DATALOAD_MYPASTEVENTS_SCROLL_FULLVIEWPREVIEW:
                return [PoP_EventsCreation_Module_Processor_CustomFilters::class, PoP_EventsCreation_Module_Processor_CustomFilters::MODULE_FILTER_MYEVENTS];
        }

        return parent::getFilterSubmodule($component);
    }

    public function getFormat(array $component): ?string
    {

        // Add the format attr
        $tables = array(
            [self::class, self::MODULE_DATALOAD_MYEVENTS_TABLE_EDIT],
            [self::class, self::MODULE_DATALOAD_MYPASTEVENTS_TABLE_EDIT],
        );
        $simpleviews = array(
            [self::class, self::MODULE_DATALOAD_MYEVENTS_SCROLL_SIMPLEVIEWPREVIEW],
            [self::class, self::MODULE_DATALOAD_MYPASTEVENTS_SCROLL_SIMPLEVIEWPREVIEW],
        );
        $fullviews = array(
            [self::class, self::MODULE_DATALOAD_MYEVENTS_SCROLL_FULLVIEWPREVIEW],
            [self::class, self::MODULE_DATALOAD_MYPASTEVENTS_SCROLL_FULLVIEWPREVIEW],
        );
        if (in_array($component, $tables)) {
            $format = POP_FORMAT_TABLE;
        } elseif (in_array($component, $simpleviews)) {
            $format = POP_FORMAT_SIMPLEVIEW;
        } elseif (in_array($component, $fullviews)) {
            $format = POP_FORMAT_FULLVIEW;
        }

        return $format ?? parent::getFormat($component);
    }

    protected function getImmutableDataloadQueryArgs(array $component, array &$props): array
    {
        $ret = parent::getImmutableDataloadQueryArgs($component, $props);

        switch ($component[1]) {
            case self::MODULE_DATALOAD_MYPASTEVENTS_TABLE_EDIT:
            case self::MODULE_DATALOAD_MYPASTEVENTS_SCROLL_SIMPLEVIEWPREVIEW:
            case self::MODULE_DATALOAD_MYPASTEVENTS_SCROLL_FULLVIEWPREVIEW:
                $this->addPastEventImmutableDataloadQueryArgs($ret);
                break;
        }

        return $ret;
    }

    public function getRelationalTypeResolver(array $component): ?\PoP\ComponentModel\TypeResolvers\RelationalTypeResolverInterface
    {
        switch ($component[1]) {
            case self::MODULE_DATALOAD_MYEVENTS_TABLE_EDIT:
            case self::MODULE_DATALOAD_MYEVENTS_SCROLL_SIMPLEVIEWPREVIEW:
            case self::MODULE_DATALOAD_MYEVENTS_SCROLL_FULLVIEWPREVIEW:
            case self::MODULE_DATALOAD_MYPASTEVENTS_TABLE_EDIT:
            case self::MODULE_DATALOAD_MYPASTEVENTS_SCROLL_SIMPLEVIEWPREVIEW:
            case self::MODULE_DATALOAD_MYPASTEVENTS_SCROLL_FULLVIEWPREVIEW:
                return $this->instanceManager->getInstance(EventObjectTypeResolver::class);
        }

        return parent::getRelationalTypeResolver($component);
    }

    public function initModelProps(array $component, array &$props): void
    {

        // Events: choose to only select past/future
        $past = array(
            [self::class, self::MODULE_DATALOAD_MYPASTEVENTS_TABLE_EDIT],
            [self::class, self::MODULE_DATALOAD_MYPASTEVENTS_SCROLL_SIMPLEVIEWPREVIEW],
            [self::class, self::MODULE_DATALOAD_MYPASTEVENTS_SCROLL_FULLVIEWPREVIEW],
        );
        $future = array(
            [self::class, self::MODULE_DATALOAD_MYEVENTS_TABLE_EDIT],
            [self::class, self::MODULE_DATALOAD_MYEVENTS_SCROLL_SIMPLEVIEWPREVIEW],
            [self::class, self::MODULE_DATALOAD_MYEVENTS_SCROLL_FULLVIEWPREVIEW],
        );
        if (in_array($component, $past)) {
            $daterange_class = 'daterange-past opens-right';
        } elseif (in_array($component, $future)) {
            $daterange_class = 'daterange-future opens-right';
        }
        if ($daterange_class) {
            $this->setProp([PoP_Events_Module_Processor_DateRangeComponentFilterInputs::class, PoP_Events_Module_Processor_DateRangeComponentFilterInputs::MODULE_FILTERINPUT_EVENTSCOPE], $props, 'daterange-class', $daterange_class);
        }

        parent::initModelProps($component, $props);
    }
}



