<?php

declare(strict_types=1);

namespace PoPSitesWassup\EverythingElseMutations\SchemaServices\MutationResolverBridges;

use PoP\ComponentModel\MutationResolverBridges\AbstractComponentMutationResolverBridge;
use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
use PoP\GraphQLParser\Spec\Parser\Ast\Argument;
use PoP\GraphQLParser\Spec\Parser\Ast\ArgumentValue\Literal;
use PoP\Root\App;
use PoP_Module_Processor_CreateUpdateUserTextFormInputs;
use PoPSitesWassup\EverythingElseMutations\SchemaServices\MutationResolvers\ChangeUserPasswordMutationResolver;

class ChangeUserPasswordMutationResolverBridge extends AbstractComponentMutationResolverBridge
{
    private ?ChangeUserPasswordMutationResolver $changeUserPasswordMutationResolver = null;
    
    final public function setChangeUserPasswordMutationResolver(ChangeUserPasswordMutationResolver $changeUserPasswordMutationResolver): void
    {
        $this->changeUserPasswordMutationResolver = $changeUserPasswordMutationResolver;
    }
    final protected function getChangeUserPasswordMutationResolver(): ChangeUserPasswordMutationResolver
    {
        return $this->changeUserPasswordMutationResolver ??= $this->instanceManager->getInstance(ChangeUserPasswordMutationResolver::class);
    }
    
    public function getMutationResolver(): MutationResolverInterface
    {
        return $this->getChangeUserPasswordMutationResolver();
    }

    public function appendMutationDataToFieldDataProvider(\PoP\ComponentModel\Mutation\FieldDataProviderInterface $fieldDataProvider): void
    {
        $user_id = App::getState('current-user-id');
        
        $fieldDataProvider->add('user_id', $user_id);
        $fieldDataProvider->add('current_password', $this->getComponentProcessorManager()->getComponentProcessor([PoP_Module_Processor_CreateUpdateUserTextFormInputs::class, PoP_Module_Processor_CreateUpdateUserTextFormInputs::COMPONENT_FORMINPUT_CUU_CURRENTPASSWORD])->getValue([PoP_Module_Processor_CreateUpdateUserTextFormInputs::class, PoP_Module_Processor_CreateUpdateUserTextFormInputs::COMPONENT_FORMINPUT_CUU_CURRENTPASSWORD]));
        $fieldDataProvider->add('password', $this->getComponentProcessorManager()->getComponentProcessor([PoP_Module_Processor_CreateUpdateUserTextFormInputs::class, PoP_Module_Processor_CreateUpdateUserTextFormInputs::COMPONENT_FORMINPUT_CUU_NEWPASSWORD])->getValue([PoP_Module_Processor_CreateUpdateUserTextFormInputs::class, PoP_Module_Processor_CreateUpdateUserTextFormInputs::COMPONENT_FORMINPUT_CUU_NEWPASSWORD]));
        $fieldDataProvider->add('repeat_password', $this->getComponentProcessorManager()->getComponentProcessor([PoP_Module_Processor_CreateUpdateUserTextFormInputs::class, PoP_Module_Processor_CreateUpdateUserTextFormInputs::COMPONENT_FORMINPUT_CUU_NEWPASSWORDREPEAT])->getValue([PoP_Module_Processor_CreateUpdateUserTextFormInputs::class, PoP_Module_Processor_CreateUpdateUserTextFormInputs::COMPONENT_FORMINPUT_CUU_NEWPASSWORDREPEAT]));
    }
}
