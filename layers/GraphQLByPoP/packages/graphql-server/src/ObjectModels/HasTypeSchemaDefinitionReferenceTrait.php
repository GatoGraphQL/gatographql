<?php

declare(strict_types=1);

namespace GraphQLByPoP\GraphQLServer\ObjectModels;

use GraphQLByPoP\GraphQLServer\Facades\Registries\SchemaDefinitionReferenceRegistryFacade;
use GraphQLByPoP\GraphQLServer\Schema\GraphQLSchemaHelpers;
use GraphQLByPoP\GraphQLServer\Schema\SchemaDefinitionHelpers;
use PoP\API\Schema\SchemaDefinition;

trait HasTypeSchemaDefinitionReferenceTrait
{
    /**
     * Lazy load the type, because it may not exist in the registry yet
     * when initializing the Field/InputValue
     */
    protected ?TypeInterface $type = null;
    
    public function getType(): TypeInterface
    {
        if ($this->type === null) {
            $this->initType();
        }
        return $this->type;
    }

    private function getInnermostTypeID(): string
    {
        return SchemaDefinitionHelpers::getSchemaDefinitionReferenceObjectID([
            SchemaDefinition::TYPES,
            $this->schemaDefinition[SchemaDefinition::TYPE_KIND],
            $this->schemaDefinition[SchemaDefinition::TYPE_NAME],
        ]);
    }

    private function initType(): void
    {
        $schemaDefinitionReferenceRegistry = SchemaDefinitionReferenceRegistryFacade::getInstance();
        $typeID = $this->getInnermostTypeID();
        /** @var TypeInterface */
        $type = $schemaDefinitionReferenceRegistry->getSchemaDefinitionReferenceObject($typeID);

        /**
         * Either retrieve the object from the registry if it exists,
         * or create it.
         */
        $isArrayOfArrays = $this->schemaDefinition[SchemaDefinition::IS_ARRAY_OF_ARRAYS] ?? false;
        $isNonNullItemsInArrayOfArrays = $this->schemaDefinition[SchemaDefinition::IS_NON_NULLABLE_ITEMS_IN_ARRAY_OF_ARRAYS] ?? false;
        $isArray = $this->schemaDefinition[SchemaDefinition::IS_ARRAY] ?? false;
        $isNonNullItemsInArray = $this->schemaDefinition[SchemaDefinition::IS_NON_NULLABLE_ITEMS_IN_ARRAY] ?? false;
        $isNonNullableOrMandatory = ($this->schemaDefinition[SchemaDefinition::NON_NULLABLE] ?? false) || ($this->schemaDefinition[SchemaDefinition::MANDATORY] ?? false);
        if ($isArrayOfArrays) {
			if ($isNonNullItemsInArrayOfArrays) {
                $typeID = GraphQLSchemaHelpers::getNonNullableOrMandatoryTypeName($typeID);
                $maybeRegisteredType = $schemaDefinitionReferenceRegistry->getSchemaDefinitionReferenceObject($typeID);
                $type = $maybeRegisteredType !== null ? $maybeRegisteredType : new NonNullWrappingType($type);
			}
            $typeID = GraphQLSchemaHelpers::getListTypeName($typeID);
            $maybeRegisteredType = $schemaDefinitionReferenceRegistry->getSchemaDefinitionReferenceObject($typeID);
            $type = $maybeRegisteredType !== null ? $maybeRegisteredType : new ListWrappingType($type);
		}
		if ($isArray) {
			if ($isNonNullItemsInArray) {
				$typeID = GraphQLSchemaHelpers::getNonNullableOrMandatoryTypeName($typeID);
                $maybeRegisteredType = $schemaDefinitionReferenceRegistry->getSchemaDefinitionReferenceObject($typeID);
                $type = $maybeRegisteredType !== null ? $maybeRegisteredType : new NonNullWrappingType($type);
			}
			$typeID = GraphQLSchemaHelpers::getListTypeName($typeID);
            $maybeRegisteredType = $schemaDefinitionReferenceRegistry->getSchemaDefinitionReferenceObject($typeID);
            $type = $maybeRegisteredType !== null ? $maybeRegisteredType : new ListWrappingType($type);
		}
		if ($isNonNullableOrMandatory) {
			$typeID = GraphQLSchemaHelpers::getNonNullableOrMandatoryTypeName($typeID);
            $maybeRegisteredType = $schemaDefinitionReferenceRegistry->getSchemaDefinitionReferenceObject($typeID);
            $type = $maybeRegisteredType !== null ? $maybeRegisteredType : new NonNullWrappingType($type);
		}
        $this->type = $type;
    }
}
