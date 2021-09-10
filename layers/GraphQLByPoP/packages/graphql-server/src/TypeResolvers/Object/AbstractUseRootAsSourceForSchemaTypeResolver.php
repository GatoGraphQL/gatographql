<?php

declare(strict_types=1);

namespace GraphQLByPoP\GraphQLServer\TypeResolvers\Object;

use PoP\ComponentModel\FieldInterfaceResolvers\FieldInterfaceResolverInterface;
use PoP\ComponentModel\FieldResolvers\ObjectTypeFieldResolverInterface;
use PoP\ComponentModel\TypeResolvers\Object\AbstractObjectTypeResolver;
use PoP\Engine\TypeResolvers\Object\RootTypeResolver;

abstract class AbstractUseRootAsSourceForSchemaTypeResolver extends AbstractObjectTypeResolver
{
    protected function getTypeResolverClassToCalculateSchema(): string
    {
        return RootTypeResolver::class;
    }

    abstract protected function isFieldNameConditionSatisfiedForSchema(ObjectTypeFieldResolverInterface $fieldResolver, string $fieldName): bool;

    protected function isFieldNameResolvedByFieldResolver(
        ObjectTypeFieldResolverInterface | FieldInterfaceResolverInterface $fieldOrFieldInterfaceResolver,
        string $fieldName,
        array $interfaceTypeResolverClasses,
    ): bool {
        if (!$this->isFieldNameConditionSatisfiedForSchema($fieldOrFieldInterfaceResolver, $fieldName)) {
            return false;
        }
        return parent::isFieldNameResolvedByFieldResolver(
            $fieldOrFieldInterfaceResolver,
            $fieldName,
            $interfaceTypeResolverClasses
        );
    }
}
