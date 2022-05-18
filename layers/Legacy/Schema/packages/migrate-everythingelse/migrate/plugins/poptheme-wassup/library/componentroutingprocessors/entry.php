<?php

class PoP_Module_EntryComponentRoutingProcessor extends \PoP\ComponentRouting\AbstractEntryComponentRoutingProcessor
{
    /**
     * @return array<array<string, string[]>>
     */
    public function getStatePropertiesToSelectComponent(): array
    {
        $ret = array();

        // Theme Modes
        $thememode_componentVariations = array(
            GD_THEMEMODE_WASSUP_EMBED => [PoP_Module_Processor_Entries::class, PoP_Module_Processor_Entries::MODULE_ENTRY_EMBED],
            GD_THEMEMODE_WASSUP_PRINT => [PoP_Module_Processor_Entries::class, PoP_Module_Processor_Entries::MODULE_ENTRY_PRINT],
        );
        foreach ($thememode_componentVariations as $thememode => $componentVariation) {
            $ret[] = [
                'component-variation' => $componentVariation,
                'conditions' => [
                    'thememode' => $thememode,
                ],
            ];
        }

        // The TopLevel is the entry module by default
        $ret[] = [
            'component-variation' => [PoP_Module_Processor_Entries::class, PoP_Module_Processor_Entries::MODULE_ENTRY_DEFAULT],
        ];

        return $ret;
    }
}

/**
 * Initialization
 */
add_action('init', function() {
	\PoP\ComponentRouting\Facades\ComponentRoutingProcessorManagerFacade::getInstance()->addComponentRoutingProcessor(
    new PoP_Module_EntryComponentRoutingProcessor()
	);
}, 200);
