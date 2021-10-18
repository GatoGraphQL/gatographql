<?php

declare(strict_types=1);

namespace PoP\API\ObjectModels\SchemaDefinition;

use PoP\API\Schema\TypeKinds;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\TypeResolvers\EnumType\EnumTypeResolverInterface;

class EnumTypeSchemaDefinitionProvider extends AbstractTypeSchemaDefinitionProvider
{
    public function __construct(
        protected EnumTypeResolverInterface $enumTypeResolver,
    ) {
        parent::__construct($enumTypeResolver);
    }

    public function getTypeKind(): string
    {
        return TypeKinds::ENUM;
    }

    public function getSchemaDefinition(): array
    {
        $schemaDefinition = parent::getSchemaDefinition();

        $this->addEnumSchemaDefinition($schemaDefinition);

        return $schemaDefinition;
    }

    /**
     * Add the enum values in the schema: arrays of enum name,
     * description, deprecated and deprecation description
     */
    protected function addEnumSchemaDefinition(array &$schemaDefinition): void
    {
        $enums = [];
        $enumValues = $this->enumTypeResolver->getEnumValues();
        $enumValueDeprecationMessages = $this->enumTypeResolver->getEnumValueDeprecationMessages();
        $enumValueDescriptions = $this->enumTypeResolver->getEnumValueDescriptions();
        foreach ($enumValues as $enumValue) {
            $enum = [
                SchemaDefinition::VALUE => $enumValue,
            ];
            if ($description = $enumValueDescriptions[$enumValue] ?? null) {
                $enum[SchemaDefinition::DESCRIPTION] = $description;
            }
            if ($deprecationMessage = $enumValueDeprecationMessages[$enumValue] ?? null) {
                $enum[SchemaDefinition::DEPRECATED] = true;
                $enum[SchemaDefinition::DEPRECATION_MESSAGE] = $deprecationMessage;
            }
            $enums[$enumValue] = $enum;
        }
        $schemaDefinition[SchemaDefinition::ITEMS] = $enums;
    }
}
