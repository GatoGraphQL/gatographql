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

    public function getComponentVariationsToProcess(): array
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

    public function getRelevantRoute(array $componentVariation, array &$props): ?string
    {
        return match($componentVariation[1]) {
            self::MODULE_DATALOAD_AUTHORLOCATIONPOSTS_HORIZONTALSCROLLMAP => POP_LOCATIONPOSTS_ROUTE_LOCATIONPOSTS,
            self::MODULE_DATALOAD_AUTHORLOCATIONPOSTS_SCROLLMAP => POP_LOCATIONPOSTS_ROUTE_LOCATIONPOSTS,
            self::MODULE_DATALOAD_LOCATIONPOSTS_HORIZONTALSCROLLMAP => POP_LOCATIONPOSTS_ROUTE_LOCATIONPOSTS,
            self::MODULE_DATALOAD_LOCATIONPOSTS_SCROLLMAP => POP_LOCATIONPOSTS_ROUTE_LOCATIONPOSTS,
            self::MODULE_DATALOAD_TAGLOCATIONPOSTS_HORIZONTALSCROLLMAP => POP_LOCATIONPOSTS_ROUTE_LOCATIONPOSTS,
            self::MODULE_DATALOAD_TAGLOCATIONPOSTS_SCROLLMAP => POP_LOCATIONPOSTS_ROUTE_LOCATIONPOSTS,
            default => parent::getRelevantRoute($componentVariation, $props),
        };
    }

    public function getInnerSubmodule(array $componentVariation)
    {
        $inner_componentVariations = array(
            self::MODULE_DATALOAD_LOCATIONPOSTS_SCROLLMAP => [GD_Custom_Module_Processor_CustomScrollMapSections::class, GD_Custom_Module_Processor_CustomScrollMapSections::MODULE_SCROLLMAP_LOCATIONPOSTS_SCROLLMAP],
            self::MODULE_DATALOAD_LOCATIONPOSTS_HORIZONTALSCROLLMAP => [GD_Custom_Module_Processor_CustomScrollMapSections::class, GD_Custom_Module_Processor_CustomScrollMapSections::MODULE_SCROLLMAP_LOCATIONPOSTS_HORIZONTALSCROLLMAP],
            self::MODULE_DATALOAD_AUTHORLOCATIONPOSTS_SCROLLMAP => [GD_Custom_Module_Processor_CustomScrollMapSections::class, GD_Custom_Module_Processor_CustomScrollMapSections::MODULE_SCROLLMAP_AUTHORLOCATIONPOSTS_SCROLLMAP],
            self::MODULE_DATALOAD_AUTHORLOCATIONPOSTS_HORIZONTALSCROLLMAP => [GD_Custom_Module_Processor_CustomScrollMapSections::class, GD_Custom_Module_Processor_CustomScrollMapSections::MODULE_SCROLLMAP_AUTHORLOCATIONPOSTS_HORIZONTALSCROLLMAP],
            self::MODULE_DATALOAD_TAGLOCATIONPOSTS_SCROLLMAP => [GD_Custom_Module_Processor_CustomScrollMapSections::class, GD_Custom_Module_Processor_CustomScrollMapSections::MODULE_SCROLLMAP_TAGLOCATIONPOSTS_SCROLLMAP],
            self::MODULE_DATALOAD_TAGLOCATIONPOSTS_HORIZONTALSCROLLMAP => [GD_Custom_Module_Processor_CustomScrollMapSections::class, GD_Custom_Module_Processor_CustomScrollMapSections::MODULE_SCROLLMAP_TAGLOCATIONPOSTS_HORIZONTALSCROLLMAP],
        );

        return $inner_componentVariations[$componentVariation[1]] ?? null;
    }

    public function getFilterSubmodule(array $componentVariation): ?array
    {
        switch ($componentVariation[1]) {
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

        return parent::getFilterSubmodule($componentVariation);
    }

    public function getFormat(array $componentVariation): ?string
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

        if (in_array($componentVariation, $maps)) {
            $format = POP_FORMAT_MAP;
        } elseif (in_array($componentVariation, $horizontalmaps)) {
            $format = POP_FORMAT_HORIZONTALMAP;
        }

        return $format ?? parent::getFormat($componentVariation);
    }
    // public function getNature(array $componentVariation)
    // {
    //     switch ($componentVariation[1]) {
    //         case self::MODULE_DATALOAD_AUTHORLOCATIONPOSTS_SCROLLMAP:
    //         case self::MODULE_DATALOAD_AUTHORLOCATIONPOSTS_HORIZONTALSCROLLMAP:
    //             return UserRequestNature::USER;

    //         case self::MODULE_DATALOAD_TAGLOCATIONPOSTS_SCROLLMAP:
    //         case self::MODULE_DATALOAD_TAGLOCATIONPOSTS_HORIZONTALSCROLLMAP:
    //             return TagRequestNature::TAG;
    //     }

    //     return parent::getNature($componentVariation);
    // }

    protected function getMutableonrequestDataloadQueryArgs(array $componentVariation, array &$props): array
    {
        $ret = parent::getMutableonrequestDataloadQueryArgs($componentVariation, $props);

        switch ($componentVariation[1]) {
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

    public function getRelationalTypeResolver(array $componentVariation): ?\PoP\ComponentModel\TypeResolvers\RelationalTypeResolverInterface
    {
        switch ($componentVariation[1]) {
            case self::MODULE_DATALOAD_LOCATIONPOSTS_SCROLLMAP:
            case self::MODULE_DATALOAD_LOCATIONPOSTS_HORIZONTALSCROLLMAP:
            case self::MODULE_DATALOAD_AUTHORLOCATIONPOSTS_SCROLLMAP:
            case self::MODULE_DATALOAD_AUTHORLOCATIONPOSTS_HORIZONTALSCROLLMAP:
            case self::MODULE_DATALOAD_TAGLOCATIONPOSTS_SCROLLMAP:
            case self::MODULE_DATALOAD_TAGLOCATIONPOSTS_HORIZONTALSCROLLMAP:
                return $this->instanceManager->getInstance(LocationPostObjectTypeResolver::class);
        }

        return parent::getRelationalTypeResolver($componentVariation);
    }

    public function initModelProps(array $componentVariation, array &$props): void
    {
        switch ($componentVariation[1]) {
            case self::MODULE_DATALOAD_LOCATIONPOSTS_SCROLLMAP:
            case self::MODULE_DATALOAD_LOCATIONPOSTS_HORIZONTALSCROLLMAP:
            case self::MODULE_DATALOAD_AUTHORLOCATIONPOSTS_SCROLLMAP:
            case self::MODULE_DATALOAD_AUTHORLOCATIONPOSTS_HORIZONTALSCROLLMAP:
            case self::MODULE_DATALOAD_TAGLOCATIONPOSTS_SCROLLMAP:
            case self::MODULE_DATALOAD_TAGLOCATIONPOSTS_HORIZONTALSCROLLMAP:
                $this->setProp([PoP_Module_Processor_DomainFeedbackMessageLayouts::class, PoP_Module_Processor_DomainFeedbackMessageLayouts::MODULE_LAYOUT_FEEDBACKMESSAGE_ITEMLIST], $props, 'pluralname', PoP_LocationPosts_PostNameUtils::getNamesLc());
                break;
        }

        parent::initModelProps($componentVariation, $props);
    }
}



