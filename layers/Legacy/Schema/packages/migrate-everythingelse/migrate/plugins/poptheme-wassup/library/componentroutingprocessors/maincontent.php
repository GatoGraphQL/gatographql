<?php

use PoP\Root\Routing\RequestNature;
use PoPCMSSchema\CustomPosts\Routing\RequestNature as CustomPostRequestNature;
use PoPCMSSchema\Pages\Routing\RequestNature as PageRequestNature;
use PoPCMSSchema\Tags\Routing\RequestNature as TagRequestNature;
use PoPCMSSchema\Users\Routing\RequestNature as UserRequestNature;

class PoP_Module_MainContentComponentRoutingProcessor extends \PoP\Application\AbstractMainContentComponentRoutingProcessor
{
    /**
     * @return array<string, array<string, array<array>>>
     */
    public function getStatePropertiesToSelectComponentByNatureAndRoute(): array
    {
        $ret = array();

        // Author
        $modules = array(
            POP_ROUTE_DESCRIPTION => [PoP_Module_Processor_CustomContentBlocks::class, PoP_Module_Processor_CustomContentBlocks::MODULE_BLOCK_AUTHOR_CONTENT],
        );
        foreach ($modules as $route => $module) {
            $ret[UserRequestNature::USER][$route][] = ['component-variation' => $module];
        }
        // Tag
        $modules = array(
            POP_ROUTE_DESCRIPTION => [PoP_Module_Processor_CustomContentBlocks::class, PoP_Module_Processor_CustomContentBlocks::MODULE_BLOCK_TAG_CONTENT],
        );
        foreach ($modules as $route => $module) {
            $ret[TagRequestNature::TAG][$route][] = ['component-variation' => $module];
        }

        // Single main content
        $default_format_singleusers = PoP_Application_Utils::getDefaultformatByScreen(POP_SCREEN_SINGLEUSERS);
        $routemodules_userdetails = array(
            POP_ROUTE_AUTHORS => [PoP_Module_Processor_SectionBlocks::class, PoP_Module_Processor_SectionBlocks::MODULE_BLOCK_SINGLEAUTHORS_SCROLL_DETAILS],
        );
        foreach ($routemodules_userdetails as $route => $module) {
            $ret[CustomPostRequestNature::CUSTOMPOST][$route][] = [
                'component-variation' => $module,
                'conditions' => [
                    'format' => POP_FORMAT_DETAILS,
                ],
            ];
            if ($default_format_singleusers == POP_FORMAT_DETAILS) {
                $ret[CustomPostRequestNature::CUSTOMPOST][$route][] = ['component-variation' => $module];
            }
        }
        $routemodules_userfullview = array(
            POP_ROUTE_AUTHORS => [PoP_Module_Processor_SectionBlocks::class, PoP_Module_Processor_SectionBlocks::MODULE_BLOCK_SINGLEAUTHORS_SCROLL_FULLVIEW],
        );
        foreach ($routemodules_userfullview as $route => $module) {
            $ret[CustomPostRequestNature::CUSTOMPOST][$route][] = [
                'component-variation' => $module,
                'conditions' => [
                    'format' => POP_FORMAT_FULLVIEW,
                ],
            ];
            if ($default_format_singleusers == POP_FORMAT_FULLVIEW) {
                $ret[CustomPostRequestNature::CUSTOMPOST][$route][] = ['component-variation' => $module];
            }
        }
        $routemodules_userthumbnail = array(
            POP_ROUTE_AUTHORS => [PoP_Module_Processor_SectionBlocks::class, PoP_Module_Processor_SectionBlocks::MODULE_BLOCK_SINGLEAUTHORS_SCROLL_THUMBNAIL],
        );
        foreach ($routemodules_userthumbnail as $route => $module) {
            $ret[CustomPostRequestNature::CUSTOMPOST][$route][] = [
                'component-variation' => $module,
                'conditions' => [
                    'format' => POP_FORMAT_THUMBNAIL,
                ],
            ];
            if ($default_format_singleusers == POP_FORMAT_THUMBNAIL) {
                $ret[CustomPostRequestNature::CUSTOMPOST][$route][] = ['component-variation' => $module];
            }
        }
        $routemodules_userlist = array(
            POP_ROUTE_AUTHORS => [PoP_Module_Processor_SectionBlocks::class, PoP_Module_Processor_SectionBlocks::MODULE_BLOCK_SINGLEAUTHORS_SCROLL_LIST],
        );
        foreach ($routemodules_userlist as $route => $module) {
            $ret[CustomPostRequestNature::CUSTOMPOST][$route][] = [
                'component-variation' => $module,
                'conditions' => [
                    'format' => POP_FORMAT_LIST,
                ],
            ];
            if ($default_format_singleusers == POP_FORMAT_LIST) {
                $ret[CustomPostRequestNature::CUSTOMPOST][$route][] = ['component-variation' => $module];
            }
        }

        return $ret;
    }

    /**
     * @return array<string, array<array>>
     */
    public function getStatePropertiesToSelectComponentByNature(): array
    {
        $ret = array();

        // 404
        $ret[RequestNature::NOTFOUND][] = [
            'component-variation' => [PoP_Module_Processor_Codes::class, PoP_Module_Processor_Codes::MODULE_CODE_404]
        ];

        // Single
        $ret[CustomPostRequestNature::CUSTOMPOST][] = [
            'component-variation' => [PoP_Module_Processor_CustomContentBlocks::class, PoP_Module_Processor_CustomContentBlocks::MODULE_BLOCK_SINGLE_CONTENT]
        ];

        // Page
        $ret[PageRequestNature::PAGE][] = [
            'component-variation' => [PoP_Module_Processor_CustomContentBlocks::class, PoP_Module_Processor_CustomContentBlocks::MODULE_BLOCK_PAGE_CONTENT]
        ];

        return $ret;
    }
}

/**
 * Initialization
 */
add_action('init', function() {
	\PoP\ComponentRouting\Facades\ComponentRoutingProcessorManagerFacade::getInstance()->addComponentRoutingProcessor(
		new PoP_Module_MainContentComponentRoutingProcessor()
	);
}, 200);
