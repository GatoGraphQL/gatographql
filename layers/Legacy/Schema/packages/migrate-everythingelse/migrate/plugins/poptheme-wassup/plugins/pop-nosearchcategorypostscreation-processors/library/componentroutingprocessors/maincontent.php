<?php

use PoP\Root\Routing\RequestNature;

class PoP_NoSearchCategoryPostsCreation_Module_MainContentComponentRoutingProcessor extends \PoP\Application\AbstractMainContentComponentRoutingProcessor
{
    /**
     * @return array<string, array<string, array<array>>>
     */
    public function getStatePropertiesToSelectComponentByNatureAndRoute(): array
    {
        $ret = array();

        $default_format_mycontent = PoP_Application_Utils::getDefaultformatByScreen(POP_SCREEN_MYCONTENT);
        $routemodules_mycontent = array(
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS00 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS00_TABLE_EDIT],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS01 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS01_TABLE_EDIT],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS02 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS02_TABLE_EDIT],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS03 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS03_TABLE_EDIT],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS04 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS04_TABLE_EDIT],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS05 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS05_TABLE_EDIT],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS06 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS06_TABLE_EDIT],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS07 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS07_TABLE_EDIT],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS08 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS08_TABLE_EDIT],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS09 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS09_TABLE_EDIT],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS10 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS10_TABLE_EDIT],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS11 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS11_TABLE_EDIT],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS12 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS12_TABLE_EDIT],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS13 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS13_TABLE_EDIT],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS14 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS14_TABLE_EDIT],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS15 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS15_TABLE_EDIT],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS16 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS16_TABLE_EDIT],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS17 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS17_TABLE_EDIT],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS18 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS18_TABLE_EDIT],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS19 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS19_TABLE_EDIT],
        );
        foreach ($routemodules_mycontent as $route => $component) {
            $ret[RequestNature::GENERIC][$route][] = [
                'component' => $component,
                'conditions' => [
                    'format' => POP_FORMAT_TABLE,
                ],
            ];
            if ($default_format_mycontent == POP_FORMAT_TABLE) {
                $ret[RequestNature::GENERIC][$route][] = ['component' => $component];
            }
        }
        $routemodules_mycontent_simpleviewpreviews = array(
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS00 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS00_SCROLL_SIMPLEVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS01 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS01_SCROLL_SIMPLEVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS02 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS02_SCROLL_SIMPLEVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS03 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS03_SCROLL_SIMPLEVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS04 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS04_SCROLL_SIMPLEVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS05 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS05_SCROLL_SIMPLEVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS06 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS06_SCROLL_SIMPLEVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS07 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS07_SCROLL_SIMPLEVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS08 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS08_SCROLL_SIMPLEVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS09 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS09_SCROLL_SIMPLEVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS10 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS10_SCROLL_SIMPLEVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS11 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS11_SCROLL_SIMPLEVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS12 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS12_SCROLL_SIMPLEVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS13 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS13_SCROLL_SIMPLEVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS14 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS14_SCROLL_SIMPLEVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS15 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS15_SCROLL_SIMPLEVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS16 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS16_SCROLL_SIMPLEVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS17 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS17_SCROLL_SIMPLEVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS18 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS18_SCROLL_SIMPLEVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS19 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS19_SCROLL_SIMPLEVIEWPREVIEW],
        );
        foreach ($routemodules_mycontent_simpleviewpreviews as $route => $component) {
            $ret[RequestNature::GENERIC][$route][] = [
                'component' => $component,
                'conditions' => [
                    'format' => POP_FORMAT_SIMPLEVIEW,
                ],
            ];
            if ($default_format_mycontent == POP_FORMAT_SIMPLEVIEW) {
                $ret[RequestNature::GENERIC][$route][] = ['component' => $component];
            }
        }
        $routemodules_mycontent_fullviewpreviews = array(
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS00 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS00_SCROLL_FULLVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS01 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS01_SCROLL_FULLVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS02 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS02_SCROLL_FULLVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS03 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS03_SCROLL_FULLVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS04 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS04_SCROLL_FULLVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS05 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS05_SCROLL_FULLVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS06 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS06_SCROLL_FULLVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS07 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS07_SCROLL_FULLVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS08 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS08_SCROLL_FULLVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS09 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS09_SCROLL_FULLVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS10 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS10_SCROLL_FULLVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS11 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS11_SCROLL_FULLVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS12 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS12_SCROLL_FULLVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS13 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS13_SCROLL_FULLVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS14 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS14_SCROLL_FULLVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS15 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS15_SCROLL_FULLVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS16 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS16_SCROLL_FULLVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS17 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS17_SCROLL_FULLVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS18 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS18_SCROLL_FULLVIEWPREVIEW],
            POP_NOSEARCHCATEGORYPOSTSCREATION_ROUTE_MYNOSEARCHCATEGORYPOSTS19 => [LPPC_Module_Processor_MySectionBlocks::class, LPPC_Module_Processor_MySectionBlocks::MODULE_BLOCK_MYCATEGORYPOSTS19_SCROLL_FULLVIEWPREVIEW],
        );
        foreach ($routemodules_mycontent_fullviewpreviews as $route => $component) {
            $ret[RequestNature::GENERIC][$route][] = [
                'component' => $component,
                'conditions' => [
                    'format' => POP_FORMAT_FULLVIEW,
                ],
            ];
            if ($default_format_mycontent == POP_FORMAT_FULLVIEW) {
                $ret[RequestNature::GENERIC][$route][] = ['component' => $component];
            }
        }

        return $ret;
    }
}

/**
 * Initialization
 */
add_action('init', function() {
	\PoP\ComponentRouting\Facades\ComponentRoutingProcessorManagerFacade::getInstance()->addComponentRoutingProcessor(
		new PoP_NoSearchCategoryPostsCreation_Module_MainContentComponentRoutingProcessor()
	);
}, 200);
