<?php

declare(strict_types=1);

namespace PoPCMSSchema\Taxonomies\TypeResolvers\InputObjectType;

use PoPCMSSchema\SchemaCommons\FilterInputs\ParentIDFilterInput;
use PoPCMSSchema\SchemaCommons\FilterInputs\SearchFilterInput;
use PoPCMSSchema\SchemaCommons\FilterInputs\SlugsFilterInput;
use PoPCMSSchema\SchemaCommons\TypeResolvers\InputObjectType\AbstractObjectsFilterInputObjectTypeResolver;
use PoPCMSSchema\Taxonomies\FilterInputs\HideEmptyFilterInput;
use PoP\ComponentModel\FilterInputs\FilterInputInterface;
use PoP\ComponentModel\Schema\SchemaTypeModifiers;
use PoP\ComponentModel\TypeResolvers\InputTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\ScalarType\BooleanScalarTypeResolver;
use PoP\ComponentModel\TypeResolvers\ScalarType\StringScalarTypeResolver;

abstract class AbstractTaxonomiesFilterInputObjectTypeResolver extends AbstractObjectsFilterInputObjectTypeResolver
{
    private ?StringScalarTypeResolver $stringScalarTypeResolver = null;
    private ?BooleanScalarTypeResolver $booleanScalarTypeResolver = null;
    private ?ParentIDFilterInput $parentIDFilterInput = null;
    private ?SearchFilterInput $searchFilterInput = null;
    private ?SlugsFilterInput $slugsFilterInput = null;
    private ?HideEmptyFilterInput $hideEmptyFilterInput = null;

    final public function setStringScalarTypeResolver(StringScalarTypeResolver $stringScalarTypeResolver): void
    {
        $this->stringScalarTypeResolver = $stringScalarTypeResolver;
    }
    final protected function getStringScalarTypeResolver(): StringScalarTypeResolver
    {
        /** @var StringScalarTypeResolver */
        return $this->stringScalarTypeResolver ??= $this->instanceManager->getInstance(StringScalarTypeResolver::class);
    }
    final public function setBooleanScalarTypeResolver(BooleanScalarTypeResolver $booleanScalarTypeResolver): void
    {
        $this->booleanScalarTypeResolver = $booleanScalarTypeResolver;
    }
    final protected function getBooleanScalarTypeResolver(): BooleanScalarTypeResolver
    {
        /** @var BooleanScalarTypeResolver */
        return $this->booleanScalarTypeResolver ??= $this->instanceManager->getInstance(BooleanScalarTypeResolver::class);
    }
    final public function setParentIDFilterInput(ParentIDFilterInput $parentIDFilterInput): void
    {
        $this->parentIDFilterInput = $parentIDFilterInput;
    }
    final protected function getParentIDFilterInput(): ParentIDFilterInput
    {
        /** @var ParentIDFilterInput */
        return $this->parentIDFilterInput ??= $this->instanceManager->getInstance(ParentIDFilterInput::class);
    }
    final public function setSearchFilterInput(SearchFilterInput $searchFilterInput): void
    {
        $this->searchFilterInput = $searchFilterInput;
    }
    final protected function getSearchFilterInput(): SearchFilterInput
    {
        /** @var SearchFilterInput */
        return $this->searchFilterInput ??= $this->instanceManager->getInstance(SearchFilterInput::class);
    }
    final public function setSlugsFilterInput(SlugsFilterInput $slugsFilterInput): void
    {
        $this->slugsFilterInput = $slugsFilterInput;
    }
    final protected function getSlugsFilterInput(): SlugsFilterInput
    {
        /** @var SlugsFilterInput */
        return $this->slugsFilterInput ??= $this->instanceManager->getInstance(SlugsFilterInput::class);
    }
    final public function setHideEmptyFilterInput(HideEmptyFilterInput $hideEmptyFilterInput): void
    {
        $this->hideEmptyFilterInput = $hideEmptyFilterInput;
    }
    final protected function getHideEmptyFilterInput(): HideEmptyFilterInput
    {
        /** @var HideEmptyFilterInput */
        return $this->hideEmptyFilterInput ??= $this->instanceManager->getInstance(HideEmptyFilterInput::class);
    }

    abstract protected function addParentIDInputField(): bool;

    /**
     * @return array<string,InputTypeResolverInterface>
     */
    public function getInputFieldNameTypeResolvers(): array
    {
        return array_merge(
            parent::getInputFieldNameTypeResolvers(),
            [
                'search' => $this->getStringScalarTypeResolver(),
                'slugs' => $this->getStringScalarTypeResolver(),
                'hideEmpty' => $this->getBooleanScalarTypeResolver(),
            ],
            $this->addParentIDInputField() ? [
                'parentID' => $this->getIDScalarTypeResolver(),
            ] : []
        );
    }

    public function getInputFieldDescription(string $inputFieldName): ?string
    {
        return match ($inputFieldName) {
            'search' => $this->__('Search for taxonomies containing the given string', 'taxonomies'),
            'slugs' => $this->__('Search for taxonomies with the given slugs', 'taxonomies'),
            'hideEmpty' => $this->__('Hide empty taxonomies terms?', 'taxonomies'),
            'parentID' => $this->__('Limit results to taxonomies with the given parent ID. \'0\' means \'no parent\'', 'taxonomies'),
            default => parent::getInputFieldDescription($inputFieldName),
        };
    }

    public function getInputFieldTypeModifiers(string $inputFieldName): int
    {
        return match ($inputFieldName) {
            'slugs' => SchemaTypeModifiers::IS_ARRAY | SchemaTypeModifiers::IS_NON_NULLABLE_ITEMS_IN_ARRAY,
            'hideEmpty' => SchemaTypeModifiers::NON_NULLABLE,
            default => parent::getInputFieldTypeModifiers($inputFieldName),
        };
    }

    public function getInputFieldDefaultValue(string $inputFieldName): mixed
    {
        return match ($inputFieldName) {
            'hideEmpty' => false,
            default => parent::getInputFieldDefaultValue($inputFieldName),
        };
    }

    public function getInputFieldFilterInput(string $inputFieldName): ?FilterInputInterface
    {
        return match ($inputFieldName) {
            'search' => $this->getSearchFilterInput(),
            'slugs' => $this->getSlugsFilterInput(),
            'hideEmpty' => $this->getHideEmptyFilterInput(),
            'parentID' => $this->getParentIDFilterInput(),
            default => parent::getInputFieldFilterInput($inputFieldName),
        };
    }
}
