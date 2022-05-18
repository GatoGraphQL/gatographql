<?php
use PoPCMSSchema\LocationPosts\TypeResolvers\ObjectType\LocationPostObjectTypeResolver;
use PoPCMSSchema\Tags\Routing\RequestNature as TagRequestNature;
use PoPCMSSchema\Users\Routing\RequestNature as UserRequestNature;

class GD_Custom_Module_Processor_CustomScrollMapSectionDataloads extends GD_EM_Module_Processor_ScrollMapDataloadsBase
{
    public final const MODULE_DATALOAD_LOCATIONPOSTS_SCROLLMAP = 'dataload-locationposts-scrollmap';
    public final const MODULE_DATALOAD_LOCATIONPOSTS_HORIZONTALSCROLLMAP = 'dataload-locationposts-horizontalscrollmap';
    public final const MODULE_DATALOAD_AUTHORLOCATIONPOSTS_SCROLLMAP = 'dataload-authorlocationposts-scrollmap';
    public final const MODULE_DATALOAD_AUTHORLOCATIONPOSTS_HORIZONTALSCROLLMAP = 'dataload-authorlocationposts-horizontalscrollmap';
    public final const MODULE_DATALOAD_TAGLOCATIONPOSTS_SCROLLMAP = 'dataload-taglocationposts-scrollmap';
    public final const MODULE_DATALOAD_TAGLOCATIONPOSTS_HORIZONTALSCROLLMAP = 'dataload-taglocationposts-horizontalscrollmap';

    public function getComponentsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_DATALOAD_LOCATIONPOSTS_SCROLLMAP],
            [self::class, self::MODULE_DATALOAD_LOCATIONPOSTS_HORIZONTALSCROLLMAP],
            [self::class, self::MODULE_DATALOAD_AUTHORLOCATIONPOSTS_SCROLLMAP],
            [self::class, self::MODULE_DATALOAD_AUTHORLOCATIONPOSTS_HORIZONTALSCROLLMAP],
            [self::class, self::MODULE_DATALOAD_TAGLOCATIONPOSTS_SCROLLMAP],
            [self::class, self::MODULE_DATALOAD_TAGLOCATIONPOSTS_HORIZONTALSCROLLMAP],
        );
    }

    public function getRelevantRoute(array $component, array &$props): ?string
    {
        return match($component[1]) {
            self::MODULE_DATALOAD_AUTHORLOCATIONPOSTS_HORIZONTALSCROLLMAP => POP_LOCATIONPOSTS_ROUTE_LOCATIONPOSTS,
            self::MODULE_DATALOAD_AUTHORLOCATIONPOSTS_SCROLLMAP => POP_LOCATIONPOSTS_ROUTE_LOCATIONPOSTS,
            self::MODULE_DATALOAD_LOCATIONPOSTS_HORIZONTALSCROLLMAP => POP_LOCATIONPOSTS_ROUTE_LOCATIONPOSTS,
            self::MODULE_DATALOAD_LOCATIONPOSTS_SCROLLMAP => POP_LOCATIONPOSTS_ROUTE_LOCATIONPOSTS,
            self::MODULE_DATALOAD_TAGLOCATIONPOSTS_HORIZONTALSCROLLMAP => POP_LOCATIONPOSTS_ROUTE_LOCATIONPOSTS,
            self::MODULE_DATALOAD_TAGLOCATIONPOSTS_SCROLLMAP => POP_LOCATIONPOSTS_ROUTE_LOCATIONPOSTS,
            default => parent::getRelevantRoute($component, $props),
        };
    }

    public function getInnerSubmodule(array $component)
    {
        $inner_components = array(
            self::MODULE_DATALOAD_LOCATIONPOSTS_SCROLLMAP => [GD_Custom_Module_Processor_CustomScrollMapSections::class, GD_Custom_Module_Processor_CustomScrollMapSections::MODULE_SCROLLMAP_LOCATIONPOSTS_SCROLLMAP],
            self::MODULE_DATALOAD_LOCATIONPOSTS_HORIZONTALSCROLLMAP => [GD_Custom_Module_Processor_CustomScrollMapSections::class, GD_Custom_Module_Processor_CustomScrollMapSections::MODULE_SCROLLMAP_LOCATIONPOSTS_HORIZONTALSCROLLMAP],
            self::MODULE_DATALOAD_AUTHORLOCATIONPOSTS_SCROLLMAP => [GD_Custom_Module_Processor_CustomScrollMapSections::class, GD_Custom_Module_Processor_CustomScrollMapSections::MODULE_SCROLLMAP_AUTHORLOCATIONPOSTS_SCROLLMAP],
            self::MODULE_DATALOAD_AUTHORLOCATIONPOSTS_HORIZONTALSCROLLMAP => [GD_Custom_Module_Processor_CustomScrollMapSections::class, GD_Custom_Module_Processor_CustomScrollMapSections::MODULE_SCROLLMAP_AUTHORLOCATIONPOSTS_HORIZONTALSCROLLMAP],
            self::MODULE_DATALOAD_TAGLOCATIONPOSTS_SCROLLMAP => [GD_Custom_Module_Processor_CustomScrollMapSections::class, GD_Custom_Module_Processor_CustomScrollMapSections::MODULE_SCROLLMAP_TAGLOCATIONPOSTS_SCROLLMAP],
            self::MODULE_DATALOAD_TAGLOCATIONPOSTS_HORIZONTALSCROLLMAP => [GD_Custom_Module_Processor_CustomScrollMapSections::class, GD_Custom_Module_Processor_CustomScrollMapSections::MODULE_SCROLLMAP_TAGLOCATIONPOSTS_HORIZONTALSCROLLMAP],
        );

        return $inner_components[$component[1]] ?? null;
    }

    public function getFilterSubmodule(array $component): ?array
    {
        switch ($component[1]) {
            case self::MODULE_DATALOAD_LOCATIONPOSTS_SCROLLMAP:
            case self::MODULE_DATALOAD_LOCATIONPOSTS_HORIZONTALSCROLLMAP:
                return [PoP_LocationPosts_Module_Processor_CustomFilters::class, PoP_LocationPosts_Module_Processor_CustomFilters::MODULE_FILTER_LOCATIONPOSTS];

            case self::MODULE_DATALOAD_AUTHORLOCATIONPOSTS_SCROLLMAP:
            case self::MODULE_DATALOAD_AUTHORLOCATIONPOSTS_HORIZONTALSCROLLMAP:
                return [PoP_LocationPosts_Module_Processor_CustomFilters::class, PoP_LocationPosts_Module_Processor_CustomFilters::MODULE_FILTER_AUTHORLOCATIONPOSTS];

            case self::MODULE_DATALOAD_TAGLOCATIONPOSTS_SCROLLMAP:
            case self::MODULE_DATALOAD_TAGLOCATIONPOSTS_HORIZONTALSCROLLMAP:
                return [PoP_LocationPosts_Module_Processor_CustomFilters::class, PoP_LocationPosts_Module_Processor_CustomFilters::MODULE_FILTER_TAGLOCATIONPOSTS];
        }

        return parent::getFilterSubmodule($component);
    }

    public function getFormat(array $component): ?string
    {
        $maps = array(
            [self::class, self::MODULE_DATALOAD_LOCATIONPOSTS_SCROLLMAP],
            [self::class, self::MODULE_DATALOAD_AUTHORLOCATIONPOSTS_SCROLLMAP],
            [self::class, self::MODULE_DATALOAD_TAGLOCATIONPOSTS_SCROLLMAP],
        );
        $horizontalmaps = array(
            [self::class, self::MODULE_DATALOAD_LOCATIONPOSTS_HORIZONTALSCROLLMAP],
            [self::class, self::MODULE_DATALOAD_AUTHORLOCATIONPOSTS_HORIZONTALSCROLLMAP],
            [self::class, self::MODULE_DATALOAD_TAGLOCATIONPOSTS_HORIZONTALSCROLLMAP],
        );

        if (in_array($component, $maps)) {
            $format = POP_FORMAT_MAP;
        } elseif (in_array($component, $horizontalmaps)) {
            $format = POP_FORMAT_HORIZONTALMAP;
        }

        return $format ?? parent::getFormat($component);
    }
    // public function getNature(array $component)
    // {
    //     switch ($component[1]) {
    //         case self::MODULE_DATALOAD_AUTHORLOCATIONPOSTS_SCROLLMAP:
    //         case self::MODULE_DATALOAD_AUTHORLOCATIONPOSTS_HORIZONTALSCROLLMAP:
    //             return UserRequestNature::USER;

    //         case self::MODULE_DATALOAD_TAGLOCATIONPOSTS_SCROLLMAP:
    //         case self::MODULE_DATALOAD_TAGLOCATIONPOSTS_HORIZONTALSCROLLMAP:
    //             return TagRequestNature::TAG;
    //     }

    //     return parent::getNature($component);
    // }

    protected function getMutableonrequestDataloadQueryArgs(array $component, array &$props): array
    {
        $ret = parent::getMutableonrequestDataloadQueryArgs($component, $props);

        switch ($component[1]) {
         // Filter by the Profile/Community
            case self::MODULE_DATALOAD_AUTHORLOCATIONPOSTS_SCROLLMAP:
            case self::MODULE_DATALOAD_AUTHORLOCATIONPOSTS_HORIZONTALSCROLLMAP:
                PoP_Module_Processor_CustomSectionBlocksUtils::addDataloadqueryargsAuthorcontent($ret);
                break;

            case self::MODULE_DATALOAD_TAGLOCATIONPOSTS_SCROLLMAP:
            case self::MODULE_DATALOAD_TAGLOCATIONPOSTS_HORIZONTALSCROLLMAP:
                PoP_Module_Processor_CustomSectionBlocksUtils::addDataloadqueryargsTagcontent($ret);
                break;
        }

        return $ret;
    }

    public function getRelationalTypeResolver(array $component): ?\PoP\ComponentModel\TypeResolvers\RelationalTypeResolverInterface
    {
        switch ($component[1]) {
            case self::MODULE_DATALOAD_LOCATIONPOSTS_SCROLLMAP:
            case self::MODULE_DATALOAD_LOCATIONPOSTS_HORIZONTALSCROLLMAP:
            case self::MODULE_DATALOAD_AUTHORLOCATIONPOSTS_SCROLLMAP:
            case self::MODULE_DATALOAD_AUTHORLOCATIONPOSTS_HORIZONTALSCROLLMAP:
            case self::MODULE_DATALOAD_TAGLOCATIONPOSTS_SCROLLMAP:
            case self::MODULE_DATALOAD_TAGLOCATIONPOSTS_HORIZONTALSCROLLMAP:
                return $this->instanceManager->getInstance(LocationPostObjectTypeResolver::class);
        }

        return parent::getRelationalTypeResolver($component);
    }

    public function initModelProps(array $component, array &$props): void
    {
        switch ($component[1]) {
            case self::MODULE_DATALOAD_LOCATIONPOSTS_SCROLLMAP:
            case self::MODULE_DATALOAD_LOCATIONPOSTS_HORIZONTALSCROLLMAP:
            case self::MODULE_DATALOAD_AUTHORLOCATIONPOSTS_SCROLLMAP:
            case self::MODULE_DATALOAD_AUTHORLOCATIONPOSTS_HORIZONTALSCROLLMAP:
            case self::MODULE_DATALOAD_TAGLOCATIONPOSTS_SCROLLMAP:
            case self::MODULE_DATALOAD_TAGLOCATIONPOSTS_HORIZONTALSCROLLMAP:
                $this->setProp([PoP_Module_Processor_DomainFeedbackMessageLayouts::class, PoP_Module_Processor_DomainFeedbackMessageLayouts::MODULE_LAYOUT_FEEDBACKMESSAGE_ITEMLIST], $props, 'pluralname', PoP_LocationPosts_PostNameUtils::getNamesLc());
                break;
        }

        parent::initModelProps($component, $props);
    }
}



