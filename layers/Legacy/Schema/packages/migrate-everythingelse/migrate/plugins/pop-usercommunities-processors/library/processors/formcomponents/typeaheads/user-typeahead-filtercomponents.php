<?php
use PoP\ComponentModel\ComponentProcessors\DataloadQueryArgsFilterInputComponentProcessorInterface;
use PoP\ComponentModel\ComponentProcessors\DataloadQueryArgsSchemaFilterInputComponentProcessorTrait;
use PoP\ComponentModel\Schema\SchemaTypeModifiers;
use PoP\ComponentModel\TypeResolvers\InputTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\ScalarType\IDScalarTypeResolver;
use PoP\Root\Facades\Translation\TranslationAPIFacade;
use Symfony\Contracts\Service\Attribute\Required;

class GD_URE_Module_Processor_UserSelectableTypeaheadFilterInputs extends PoP_Module_Processor_UserSelectableTypeaheadFormComponentsBase implements DataloadQueryArgsFilterInputComponentProcessorInterface
{
    use DataloadQueryArgsSchemaFilterInputComponentProcessorTrait;

    public final const MODULE_URE_FILTERCOMPONENT_SELECTABLETYPEAHEAD_COMMUNITYPLUSMEMBERS = 'filterinput-typeahead-communityplusmembers';
    public final const MODULE_URE_FILTERCOMPONENT_SELECTABLETYPEAHEAD_COMMUNITIES_POST = 'filterinput-typeahead-communities-post';
    public final const MODULE_URE_FILTERCOMPONENT_SELECTABLETYPEAHEAD_COMMUNITIES_USER = 'filterinput-typeahead-communities-user';

    private ?IDScalarTypeResolver $idScalarTypeResolver = null;

    final public function setIDScalarTypeResolver(IDScalarTypeResolver $idScalarTypeResolver): void
    {
        $this->idScalarTypeResolver = $idScalarTypeResolver;
    }
    final protected function getIDScalarTypeResolver(): IDScalarTypeResolver
    {
        return $this->idScalarTypeResolver ??= $this->instanceManager->getInstance(IDScalarTypeResolver::class);
    }

    public function getComponentsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_URE_FILTERCOMPONENT_SELECTABLETYPEAHEAD_COMMUNITIES_POST],
            [self::class, self::MODULE_URE_FILTERCOMPONENT_SELECTABLETYPEAHEAD_COMMUNITIES_USER],
            [self::class, self::MODULE_URE_FILTERCOMPONENT_SELECTABLETYPEAHEAD_COMMUNITYPLUSMEMBERS],
        );
    }

    public function getFilterInput(array $component): ?array
    {
        $filterInputs = [
            self::MODULE_URE_FILTERCOMPONENT_SELECTABLETYPEAHEAD_COMMUNITIES_POST => [GD_URE_Module_Processor_FilterInputProcessor::class, GD_URE_Module_Processor_FilterInputProcessor::URE_FILTERCOMPONENT_SELECTABLETYPEAHEAD_COMMUNITIES_POST],
            self::MODULE_URE_FILTERCOMPONENT_SELECTABLETYPEAHEAD_COMMUNITIES_USER => [GD_URE_Module_Processor_FilterInputProcessor::class, GD_URE_Module_Processor_FilterInputProcessor::URE_FILTERCOMPONENT_SELECTABLETYPEAHEAD_COMMUNITIES_USER],
            self::MODULE_URE_FILTERCOMPONENT_SELECTABLETYPEAHEAD_COMMUNITYPLUSMEMBERS => [GD_URE_Module_Processor_FilterInputProcessor::class, GD_URE_Module_Processor_FilterInputProcessor::URE_FILTERCOMPONENT_SELECTABLETYPEAHEAD_COMMUNITYPLUSMEMBERS],
        ];
        return $filterInputs[$component[1]] ?? null;
    }

    public function getLabel(array $component, array &$props)
    {
        switch ($component[1]) {
            case self::MODULE_URE_FILTERCOMPONENT_SELECTABLETYPEAHEAD_COMMUNITIES_USER:
                return TranslationAPIFacade::getInstance()->__('Member of which Communities', 'ure-popprocessors');
        }

        return parent::getLabel($component, $props);
    }

    public function getInputSubmodule(array $component)
    {
        switch ($component[1]) {
            case self::MODULE_URE_FILTERCOMPONENT_SELECTABLETYPEAHEAD_COMMUNITIES_POST:
            case self::MODULE_URE_FILTERCOMPONENT_SELECTABLETYPEAHEAD_COMMUNITIES_USER:
                return [GD_UserCommunities_Module_Processor_TypeaheadTextFormInputs::class, GD_UserCommunities_Module_Processor_TypeaheadTextFormInputs::MODULE_FORMINPUT_TEXT_TYPEAHEADCOMMUNITIES];

            case self::MODULE_URE_FILTERCOMPONENT_SELECTABLETYPEAHEAD_COMMUNITYPLUSMEMBERS:
                return [PoP_Module_Processor_TypeaheadTextFormInputs::class, PoP_Module_Processor_TypeaheadTextFormInputs::MODULE_FORMINPUT_TEXT_TYPEAHEADPROFILES];
        }

        return parent::getInputSubmodule($component);
    }

    public function getComponentSubmodules(array $component)
    {
        switch ($component[1]) {
            case self::MODULE_URE_FILTERCOMPONENT_SELECTABLETYPEAHEAD_COMMUNITIES_POST:
            case self::MODULE_URE_FILTERCOMPONENT_SELECTABLETYPEAHEAD_COMMUNITIES_USER:
                return array(
                    [GD_URE_Module_Processor_UserTypeaheadComponentFormInputs::class, GD_URE_Module_Processor_UserTypeaheadComponentFormInputs::MODULE_URE_TYPEAHEAD_COMPONENT_COMMUNITY],
                );

            case self::MODULE_URE_FILTERCOMPONENT_SELECTABLETYPEAHEAD_COMMUNITYPLUSMEMBERS:
                return array(
                    [GD_URE_Module_Processor_UserTypeaheadComponentFormInputs::class, GD_URE_Module_Processor_UserTypeaheadComponentFormInputs::MODULE_URE_TYPEAHEAD_COMPONENT_COMMUNITYPLUSMEMBERS],
                );
        }

        return parent::getComponentSubmodules($component);
    }

    public function getTriggerLayoutSubmodule(array $component)
    {
        switch ($component[1]) {
            case self::MODULE_URE_FILTERCOMPONENT_SELECTABLETYPEAHEAD_COMMUNITYPLUSMEMBERS:
                return [PoP_Module_Processor_UserSelectableTypeaheadTriggerFormComponents::class, PoP_Module_Processor_UserSelectableTypeaheadTriggerFormComponents::MODULE_FILTERCOMPONENT_SELECTABLETYPEAHEADTRIGGER_COMMUNITYUSERS];

            case self::MODULE_URE_FILTERCOMPONENT_SELECTABLETYPEAHEAD_COMMUNITIES_POST:
            case self::MODULE_URE_FILTERCOMPONENT_SELECTABLETYPEAHEAD_COMMUNITIES_USER:
                return [GD_URE_Module_Processor_UserSelectableTypeaheadTriggerFormComponents::class, GD_URE_Module_Processor_UserSelectableTypeaheadTriggerFormComponents::MODULE_FILTERCOMPONENT_SELECTABLETYPEAHEADTRIGGER_COMMUNITIES];
        }

        return parent::getTriggerLayoutSubmodule($component);
    }

    public function getFilterInputTypeResolver(array $component): InputTypeResolverInterface
    {
        return match($component[1]) {
            self::MODULE_URE_FILTERCOMPONENT_SELECTABLETYPEAHEAD_COMMUNITIES_POST => $this->idScalarTypeResolver,
            self::MODULE_URE_FILTERCOMPONENT_SELECTABLETYPEAHEAD_COMMUNITIES_USER => $this->idScalarTypeResolver,
            self::MODULE_URE_FILTERCOMPONENT_SELECTABLETYPEAHEAD_COMMUNITYPLUSMEMBERS => $this->idScalarTypeResolver,
            default => $this->getDefaultSchemaFilterInputTypeResolver(),
        };
    }

    public function getFilterInputTypeModifiers(array $component): int
    {
        return match($component[1]) {
            self::MODULE_URE_FILTERCOMPONENT_SELECTABLETYPEAHEAD_COMMUNITIES_POST,
            self::MODULE_URE_FILTERCOMPONENT_SELECTABLETYPEAHEAD_COMMUNITIES_USER,
            self::MODULE_URE_FILTERCOMPONENT_SELECTABLETYPEAHEAD_COMMUNITYPLUSMEMBERS
                => SchemaTypeModifiers::IS_ARRAY,
            default
                => SchemaTypeModifiers::NONE,
        };
    }

    public function getFilterInputDescription(array $component): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        return match ($component[1]) {
            self::MODULE_URE_FILTERCOMPONENT_SELECTABLETYPEAHEAD_COMMUNITIES_POST => $translationAPI->__('', ''),
            self::MODULE_URE_FILTERCOMPONENT_SELECTABLETYPEAHEAD_COMMUNITIES_USER => $translationAPI->__('', ''),
            self::MODULE_URE_FILTERCOMPONENT_SELECTABLETYPEAHEAD_COMMUNITYPLUSMEMBERS => $translationAPI->__('', ''),
            default => null,
        };
    }
}



