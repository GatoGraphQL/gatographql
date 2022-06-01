<?php

use PoP\Root\Routing\RequestNature;

class PoPTheme_Wassup_LocationPostsCreation_Module_SideInfoContentPageSectionComponentRoutingProcessor extends PoP_Module_SideInfoContentPageSectionComponentRoutingProcessorBase
{
    /**
     * @return array<string,array<string,array<array<string,mixed>>>>
     */
    public function getStatePropertiesToSelectComponentByNatureAndRoute(): array
    {
        $ret = array();

        $components = array(
            POP_LOCATIONPOSTSCREATION_ROUTE_MYLOCATIONPOSTS => [PoPSPEM_Module_Processor_SidebarMultiples::class, PoPSPEM_Module_Processor_SidebarMultiples::COMPONENT_MULTIPLE_SECTION_MYLOCATIONPOSTS_SIDEBAR],
        );
        foreach ($components as $route => $component) {
            $ret[RequestNature::GENERIC][$route][] = ['component' => $component];
        }

        return $ret;
    }
}

/**
 * Initialization
 */
add_action('init', function() {
	\PoP\ComponentRouting\Facades\ComponentRoutingProcessorManagerFacade::getInstance()->addComponentRoutingProcessor(
		new PoPTheme_Wassup_LocationPostsCreation_Module_SideInfoContentPageSectionComponentRoutingProcessor()
	);
}, 200);
