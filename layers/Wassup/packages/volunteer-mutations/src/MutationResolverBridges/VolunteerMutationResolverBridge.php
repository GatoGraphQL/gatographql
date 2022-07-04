<?php

declare(strict_types=1);

namespace PoPSitesWassup\VolunteerMutations\MutationResolverBridges;

use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
use PoP_Application_Module_Processor_PostTriggerLayoutFormComponentValues;
use PoP_Forms_Module_Processor_TextFormInputs;
use PoP_Volunteering_Module_Processor_TextareaFormInputs;
use PoP_Volunteering_Module_Processor_TextFormInputs;
use PoPSitesWassup\FormMutations\MutationResolverBridges\AbstractFormComponentMutationResolverBridge;
use PoPSitesWassup\VolunteerMutations\MutationResolvers\VolunteerMutationResolver;

class VolunteerMutationResolverBridge extends AbstractFormComponentMutationResolverBridge
{
    private ?VolunteerMutationResolver $volunteerMutationResolver = null;

    final public function setVolunteerMutationResolver(VolunteerMutationResolver $volunteerMutationResolver): void
    {
        $this->volunteerMutationResolver = $volunteerMutationResolver;
    }
    final protected function getVolunteerMutationResolver(): VolunteerMutationResolver
    {
        return $this->volunteerMutationResolver ??= $this->instanceManager->getInstance(VolunteerMutationResolver::class);
    }

    public function getMutationResolver(): MutationResolverInterface
    {
        return $this->getVolunteerMutationResolver();
    }

    public function appendMutationDataToFieldDataProvider(\PoP\ComponentModel\Mutation\FieldDataProviderInterface $fieldDataProvider): void
    {
        $fieldDataProvider->add('name', $this->getComponentProcessorManager()->getComponentProcessor([PoP_Forms_Module_Processor_TextFormInputs::class, PoP_Forms_Module_Processor_TextFormInputs::COMPONENT_FORMINPUT_NAME])->getValue([PoP_Forms_Module_Processor_TextFormInputs::class, PoP_Forms_Module_Processor_TextFormInputs::COMPONENT_FORMINPUT_NAME]));
        $fieldDataProvider->add('email', $this->getComponentProcessorManager()->getComponentProcessor([PoP_Forms_Module_Processor_TextFormInputs::class, PoP_Forms_Module_Processor_TextFormInputs::COMPONENT_FORMINPUT_EMAIL])->getValue([PoP_Forms_Module_Processor_TextFormInputs::class, PoP_Forms_Module_Processor_TextFormInputs::COMPONENT_FORMINPUT_EMAIL]));
        $fieldDataProvider->add('phone', $this->getComponentProcessorManager()->getComponentProcessor([PoP_Volunteering_Module_Processor_TextFormInputs::class, PoP_Volunteering_Module_Processor_TextFormInputs::COMPONENT_FORMINPUT_PHONE])->getValue([PoP_Volunteering_Module_Processor_TextFormInputs::class, PoP_Volunteering_Module_Processor_TextFormInputs::COMPONENT_FORMINPUT_PHONE]));
        $fieldDataProvider->add('whyvolunteer', $this->getComponentProcessorManager()->getComponentProcessor([PoP_Volunteering_Module_Processor_TextareaFormInputs::class, PoP_Volunteering_Module_Processor_TextareaFormInputs::COMPONENT_FORMINPUT_WHYVOLUNTEER])->getValue([PoP_Volunteering_Module_Processor_TextareaFormInputs::class, PoP_Volunteering_Module_Processor_TextareaFormInputs::COMPONENT_FORMINPUT_WHYVOLUNTEER]));
        $fieldDataProvider->add('target-id', $this->getComponentProcessorManager()->getComponentProcessor([PoP_Application_Module_Processor_PostTriggerLayoutFormComponentValues::class, PoP_Application_Module_Processor_PostTriggerLayoutFormComponentValues::COMPONENT_FORMCOMPONENT_CARD_POST])->getValue([PoP_Application_Module_Processor_PostTriggerLayoutFormComponentValues::class, PoP_Application_Module_Processor_PostTriggerLayoutFormComponentValues::COMPONENT_FORMCOMPONENT_CARD_POST]));
    }
}
