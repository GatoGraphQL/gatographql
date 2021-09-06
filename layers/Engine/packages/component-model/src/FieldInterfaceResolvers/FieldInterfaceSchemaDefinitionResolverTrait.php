<?php

declare(strict_types=1);

namespace PoP\ComponentModel\FieldInterfaceResolvers;

use PoP\ComponentModel\Facades\Instances\InstanceManagerFacade;
use PoP\ComponentModel\Facades\Schema\SchemaDefinitionServiceFacade;
use PoP\ComponentModel\FieldInterfaceResolvers\FieldInterfaceSchemaDefinitionResolverInterface;
use PoP\ComponentModel\Resolvers\WithVersionConstraintFieldOrDirectiveResolverTrait;
use PoP\ComponentModel\TypeResolvers\RelationalTypeResolverInterface;

trait FieldInterfaceSchemaDefinitionResolverTrait
{
    use WithVersionConstraintFieldOrDirectiveResolverTrait;

    /**
     * Return the object implementing the schema definition for this fieldResolver
     */
    public function getSchemaDefinitionResolver(): ?FieldInterfaceSchemaDefinitionResolverInterface
    {
        return null;
    }

    public function getSchemaFieldType(string $fieldName): string
    {
        if ($schemaDefinitionResolver = $this->getSchemaDefinitionResolver()) {
            return $schemaDefinitionResolver->getSchemaFieldType($fieldName);
        }

        $schemaDefinitionService = SchemaDefinitionServiceFacade::getInstance();
        return $schemaDefinitionService->getDefaultType();
    }

    public function getSchemaFieldTypeModifiers(string $fieldName): ?int
    {
        if ($schemaDefinitionResolver = $this->getSchemaDefinitionResolver()) {
            return $schemaDefinitionResolver->getSchemaFieldTypeModifiers($fieldName);
        }
        return null;
    }

    public function getSchemaFieldDescription(string $fieldName): ?string
    {
        if ($schemaDefinitionResolver = $this->getSchemaDefinitionResolver()) {
            return $schemaDefinitionResolver->getSchemaFieldDescription($fieldName);
        }
        return null;
    }

    public function getSchemaFieldArgs(string $fieldName): array
    {
        if ($schemaDefinitionResolver = $this->getSchemaDefinitionResolver()) {
            return $schemaDefinitionResolver->getSchemaFieldArgs($fieldName);
        }
        return [];
    }

    public function getSchemaFieldDeprecationDescription(string $fieldName, array $fieldArgs = []): ?string
    {
        if ($schemaDefinitionResolver = $this->getSchemaDefinitionResolver()) {
            return $schemaDefinitionResolver->getSchemaFieldDeprecationDescription($fieldName, $fieldArgs);
        }
        return null;
    }

    public function resolveFieldTypeResolverClass(string $fieldName): ?string
    {
        if ($schemaDefinitionResolver = $this->getSchemaDefinitionResolver()) {
            return $schemaDefinitionResolver->resolveFieldTypeResolverClass($fieldName);
        }
        return null;
    }

    public function isFieldOfRelationalType(string $fieldName): ?bool
    {
        if ($schemaDefinitionResolver = $this->getSchemaDefinitionResolver()) {
            if ($schemaDefinitionResolver !== $this) {
                return $schemaDefinitionResolver->isFieldOfRelationalType($fieldName);
            }
        }
        $fieldTypeResolverClass = $this->resolveFieldTypeResolverClass($fieldName);
        if ($fieldTypeResolverClass === null) {
            return null;
        }
        $instanceManager = InstanceManagerFacade::getInstance();
        $fieldTypeResolver = $instanceManager->getInstance($fieldTypeResolverClass);
        return $fieldTypeResolver instanceof RelationalTypeResolverInterface;
    }

    /**
     * Validate the constraints for a field argument
     *
     * @return string[] Error messages
     */
    public function validateFieldArgument(
        string $fieldName,
        string $fieldArgName,
        mixed $fieldArgValue
    ): array {
        if ($schemaDefinitionResolver = $this->getSchemaDefinitionResolver()) {
            return $schemaDefinitionResolver->validateFieldArgument($fieldName, $fieldArgName, $fieldArgValue);
        }
        return [];
    }

    public function addSchemaDefinitionForField(array &$schemaDefinition, string $fieldName): void
    {
        if ($schemaDefinitionResolver = $this->getSchemaDefinitionResolver()) {
            $schemaDefinitionResolver->addSchemaDefinitionForField($schemaDefinition, $fieldName);
        }
    }
}
