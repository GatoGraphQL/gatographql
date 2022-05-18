<?php
use PoP\Root\Facades\Translation\TranslationAPIFacade;

class GD_Custom_Module_Processor_CustomSectionBlocks extends PoP_Module_Processor_SectionBlocksBase
{
    public final const MODULE_BLOCK_WHOWEARE_SCROLL_DETAILS = 'block-whoweare-scroll-details';
    public final const MODULE_BLOCK_WHOWEARE_SCROLL_THUMBNAIL = 'block-whoweare-scroll-thumbnail';
    public final const MODULE_BLOCK_WHOWEARE_SCROLL_LIST = 'block-whoweare-scroll-list';
    public final const MODULE_BLOCK_WHOWEARE_SCROLL_FULLVIEW = 'block-whoweare-scroll-fullview';

    public function getComponentVariationsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_BLOCK_WHOWEARE_SCROLL_DETAILS],
            [self::class, self::MODULE_BLOCK_WHOWEARE_SCROLL_THUMBNAIL],
            [self::class, self::MODULE_BLOCK_WHOWEARE_SCROLL_LIST],
            [self::class, self::MODULE_BLOCK_WHOWEARE_SCROLL_FULLVIEW],
        );
    }

    public function getRelevantRoute(array $componentVariation, array &$props): ?string
    {
        return match($componentVariation[1]) {
            self::MODULE_BLOCK_WHOWEARE_SCROLL_DETAILS => POP_COMMONPAGES_ROUTE_ABOUT_WHOWEARE,
            self::MODULE_BLOCK_WHOWEARE_SCROLL_THUMBNAIL => POP_COMMONPAGES_ROUTE_ABOUT_WHOWEARE,
            self::MODULE_BLOCK_WHOWEARE_SCROLL_LIST => POP_COMMONPAGES_ROUTE_ABOUT_WHOWEARE,
            self::MODULE_BLOCK_WHOWEARE_SCROLL_FULLVIEW => POP_COMMONPAGES_ROUTE_ABOUT_WHOWEARE,
            default => parent::getRelevantRoute($componentVariation, $props),
        };
    }

    protected function getInnerSubmodule(array $componentVariation)
    {
        $inner_componentVariations = array(
            self::MODULE_BLOCK_WHOWEARE_SCROLL_DETAILS => [GD_Custom_Module_Processor_CustomSectionDataloads::class, GD_Custom_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_WHOWEARE_SCROLL_DETAILS],
            self::MODULE_BLOCK_WHOWEARE_SCROLL_THUMBNAIL => [GD_Custom_Module_Processor_CustomSectionDataloads::class, GD_Custom_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_WHOWEARE_SCROLL_THUMBNAIL],
            self::MODULE_BLOCK_WHOWEARE_SCROLL_LIST => [GD_Custom_Module_Processor_CustomSectionDataloads::class, GD_Custom_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_WHOWEARE_SCROLL_LIST],
            self::MODULE_BLOCK_WHOWEARE_SCROLL_FULLVIEW => [GD_Custom_Module_Processor_CustomSectionDataloads::class, GD_Custom_Module_Processor_CustomSectionDataloads::MODULE_DATALOAD_WHOWEARE_SCROLL_FULLVIEW],
        );

        return $inner_componentVariations[$componentVariation[1]] ?? null;
    }

    public function getTitle(array $componentVariation, array &$props)
    {
        switch ($componentVariation[1]) {
            case self::MODULE_BLOCK_WHOWEARE_SCROLL_DETAILS:
            case self::MODULE_BLOCK_WHOWEARE_SCROLL_THUMBNAIL:
            case self::MODULE_BLOCK_WHOWEARE_SCROLL_LIST:
            case self::MODULE_BLOCK_WHOWEARE_SCROLL_FULLVIEW:
                return TranslationAPIFacade::getInstance()->__('Who we are', 'poptheme-wassup');
        }

        return parent::getTitle($componentVariation, $props);
    }
}



