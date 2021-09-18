<?php

declare(strict_types=1);

namespace PoPSitesWassup\EverythingElseMutations\SchemaServices\MutationResolverBridges;

use PoP\Hooks\HooksAPIInterface;
use PoP\Translation\TranslationAPIInterface;
use PoP\ComponentModel\Instances\InstanceManagerInterface;
use PoP\ComponentModel\MutationResolution\MutationResolutionManagerInterface;
use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
use PoPSchema\Users\Constants\InputNames;
use PoP\ComponentModel\State\ApplicationState;
use PoP\ComponentModel\MutationResolverBridges\AbstractComponentMutationResolverBridge;
use PoPSitesWassup\EverythingElseMutations\SchemaServices\MutationResolvers\EditMembershipMutationResolver;

class EditMembershipMutationResolverBridge extends AbstractComponentMutationResolverBridge
{
    public function __construct(
        HooksAPIInterface $hooksAPI,
        TranslationAPIInterface $translationAPI,
        InstanceManagerInterface $instanceManager,
        MutationResolutionManagerInterface $mutationResolutionManager,
        protected EditMembershipMutationResolver $editMembershipMutationResolver,
    ) {
        parent::__construct(
            $hooksAPI,
            $translationAPI,
            $instanceManager,
            $mutationResolutionManager,
        );
    }
    
    public function getMutationResolver(): MutationResolverInterface
    {
        return $this->editMembershipMutationResolver;
    }

    public function getFormData(): array
    {
        $vars = ApplicationState::getVars();
        $community = $vars['global-userstate']['is-user-logged-in'] ? $vars['global-userstate']['current-user-id'] : '';
        $privileges = $this->moduleProcessorManager->getProcessor([\GD_URE_Module_Processor_ProfileMultiSelectFormInputs::class, \GD_URE_Module_Processor_ProfileMultiSelectFormInputs::MODULE_URE_FORMINPUT_MEMBERPRIVILEGES])->getValue([\GD_URE_Module_Processor_ProfileMultiSelectFormInputs::class, \GD_URE_Module_Processor_ProfileMultiSelectFormInputs::MODULE_URE_FORMINPUT_MEMBERPRIVILEGES]);
        $tags = $this->moduleProcessorManager->getProcessor([\GD_URE_Module_Processor_ProfileMultiSelectFormInputs::class, \GD_URE_Module_Processor_ProfileMultiSelectFormInputs::MODULE_URE_FORMINPUT_MEMBERTAGS])->getValue([\GD_URE_Module_Processor_ProfileMultiSelectFormInputs::class, \GD_URE_Module_Processor_ProfileMultiSelectFormInputs::MODULE_URE_FORMINPUT_MEMBERTAGS]);
        $form_data = array(
            'community' => $community,
            'user_id' => $_REQUEST[InputNames::USER_ID] ?? null,
            // 'nonce' => $_REQUEST[POP_INPUTNAME_NONCE],
            'status' => trim($this->moduleProcessorManager->getProcessor([\GD_URE_Module_Processor_SelectFormInputs::class, \GD_URE_Module_Processor_SelectFormInputs::MODULE_URE_FORMINPUT_MEMBERSTATUS])->getValue([\GD_URE_Module_Processor_SelectFormInputs::class, \GD_URE_Module_Processor_SelectFormInputs::MODULE_URE_FORMINPUT_MEMBERSTATUS])),
            'privileges' => $privileges ?? array(),
            'tags' => $tags ?? array(),
        );

        return $form_data;
    }
}
