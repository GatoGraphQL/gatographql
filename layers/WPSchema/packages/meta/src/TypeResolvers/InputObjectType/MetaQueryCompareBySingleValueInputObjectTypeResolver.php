<?php

declare(strict_types=1);

namespace PoPWPSchema\Meta\TypeResolvers\InputObjectType;

use PoP\ComponentModel\Schema\SchemaTypeModifiers;
use PoP\ComponentModel\TypeResolvers\InputObjectType\AbstractInputObjectTypeResolver;
use PoP\Engine\TypeResolvers\ScalarType\AnyBuiltInScalarScalarTypeResolver;
use PoPWPSchema\Meta\Constants\MetaQueryCompareByOperators;
use PoPWPSchema\Meta\TypeResolvers\EnumType\MetaQueryCompareBySingleValueOperatorEnumTypeResolver;

class MetaQueryCompareBySingleValueInputObjectTypeResolver extends AbstractInputObjectTypeResolver
{
    private ?AnyBuiltInScalarScalarTypeResolver $anyBuiltInScalarScalarTypeResolver = null;
    private ?MetaQueryCompareBySingleValueOperatorEnumTypeResolver $metaQueryCompareBySingleValueOperatorEnumTypeResolver = null;

    final public function setAnyBuiltInScalarScalarTypeResolver(AnyBuiltInScalarScalarTypeResolver $anyBuiltInScalarScalarTypeResolver): void
    {
        $this->anyBuiltInScalarScalarTypeResolver = $anyBuiltInScalarScalarTypeResolver;
    }
    final protected function getAnyBuiltInScalarScalarTypeResolver(): AnyBuiltInScalarScalarTypeResolver
    {
        return $this->anyBuiltInScalarScalarTypeResolver ??= $this->instanceManager->getInstance(AnyBuiltInScalarScalarTypeResolver::class);
    }
    final public function setMetaQueryCompareBySingleValueOperatorEnumTypeResolver(MetaQueryCompareBySingleValueOperatorEnumTypeResolver $metaQueryCompareBySingleValueOperatorEnumTypeResolver): void
    {
        $this->metaQueryCompareBySingleValueOperatorEnumTypeResolver = $metaQueryCompareBySingleValueOperatorEnumTypeResolver;
    }
    final protected function getMetaQueryCompareBySingleValueOperatorEnumTypeResolver(): MetaQueryCompareBySingleValueOperatorEnumTypeResolver
    {
        return $this->metaQueryCompareBySingleValueOperatorEnumTypeResolver ??= $this->instanceManager->getInstance(MetaQueryCompareBySingleValueOperatorEnumTypeResolver::class);
    }

    public function getTypeName(): string
    {
        return 'MetaQueryCompareBySingleValueInput';
    }

    public function getInputFieldNameTypeResolvers(): array
    {
        return [
            'value' => $this->getAnyBuiltInScalarScalarTypeResolver(),
            'operator' => $this->getMetaQueryCompareBySingleValueOperatorEnumTypeResolver(),
        ];
    }

    public function getInputFieldDescription(string $inputFieldName): ?string
    {
        return match ($inputFieldName) {
            'value' => $this->getTranslationAPI()->__('Custom field value', 'meta'),
            'operator' => $this->getTranslationAPI()->__('The operator to compare against', 'meta'),
            default => parent::getInputFieldDescription($inputFieldName),
        };
    }

    public function getInputFieldDefaultValue(string $inputFieldName): mixed
    {
        return match ($inputFieldName) {
            'operator' => MetaQueryCompareByOperators::EQ,
            default => parent::getInputFieldDefaultValue($inputFieldName),
        };
    }

    public function getInputFieldTypeModifiers(string $inputFieldName): int
    {
        return match ($inputFieldName) {
            'value',
            'operator'
                => SchemaTypeModifiers::MANDATORY,
            default
                => parent::getInputFieldTypeModifiers($inputFieldName),
        };
    }
}
