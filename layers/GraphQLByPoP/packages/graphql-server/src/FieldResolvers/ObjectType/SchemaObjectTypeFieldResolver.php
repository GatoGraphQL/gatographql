<?php

declare(strict_types=1);

namespace GraphQLByPoP\GraphQLServer\FieldResolvers\ObjectType;

use GraphQLByPoP\GraphQLServer\ObjectModels\Schema;
use GraphQLByPoP\GraphQLServer\TypeResolvers\ObjectType\DirectiveObjectTypeResolver;
use GraphQLByPoP\GraphQLServer\TypeResolvers\ObjectType\SchemaObjectTypeResolver;
use GraphQLByPoP\GraphQLServer\TypeResolvers\ObjectType\TypeObjectTypeResolver;
use PoP\ComponentModel\FieldResolvers\ObjectType\AbstractObjectTypeFieldResolver;
use PoP\ComponentModel\Schema\SchemaTypeModifiers;
use PoP\ComponentModel\TypeResolvers\ConcreteTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\ObjectType\ObjectTypeResolverInterface;
use PoP\Engine\TypeResolvers\ScalarType\StringScalarTypeResolver;
use Symfony\Contracts\Service\Attribute\Required;

class SchemaObjectTypeFieldResolver extends AbstractObjectTypeFieldResolver
{
    private ?TypeObjectTypeResolver $typeObjectTypeResolver = null;
    private ?DirectiveObjectTypeResolver $directiveObjectTypeResolver = null;
    private ?StringScalarTypeResolver $stringScalarTypeResolver = null;

    public function setTypeObjectTypeResolver(TypeObjectTypeResolver $typeObjectTypeResolver): void
    {
        $this->typeObjectTypeResolver = $typeObjectTypeResolver;
    }
    protected function getTypeObjectTypeResolver(): TypeObjectTypeResolver
    {
        return $this->typeObjectTypeResolver ??= $this->getInstanceManager()->getInstance(TypeObjectTypeResolver::class);
    }
    public function setDirectiveObjectTypeResolver(DirectiveObjectTypeResolver $directiveObjectTypeResolver): void
    {
        $this->directiveObjectTypeResolver = $directiveObjectTypeResolver;
    }
    protected function getDirectiveObjectTypeResolver(): DirectiveObjectTypeResolver
    {
        return $this->directiveObjectTypeResolver ??= $this->getInstanceManager()->getInstance(DirectiveObjectTypeResolver::class);
    }
    public function setStringScalarTypeResolver(StringScalarTypeResolver $stringScalarTypeResolver): void
    {
        $this->stringScalarTypeResolver = $stringScalarTypeResolver;
    }
    protected function getStringScalarTypeResolver(): StringScalarTypeResolver
    {
        return $this->stringScalarTypeResolver ??= $this->getInstanceManager()->getInstance(StringScalarTypeResolver::class);
    }

    public function getObjectTypeResolverClassesToAttachTo(): array
    {
        return [
            SchemaObjectTypeResolver::class,
        ];
    }

    public function getFieldNamesToResolve(): array
    {
        return [
            'queryType',
            'mutationType',
            'subscriptionType',
            'types',
            'directives',
            'type',
        ];
    }

    public function getFieldTypeModifiers(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): int
    {
        return match ($fieldName) {
            'queryType'
                => SchemaTypeModifiers::NON_NULLABLE,
            'types',
            'directives'
                => SchemaTypeModifiers::NON_NULLABLE | SchemaTypeModifiers::IS_ARRAY,
            default
                => parent::getFieldTypeModifiers($objectTypeResolver, $fieldName),
        };
    }

    public function getFieldDescription(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): ?string
    {
        return match ($fieldName) {
            'queryType' => $this->getTranslationAPI()->__('The type, accessible from the root, that resolves queries', 'graphql-server'),
            'mutationType' => $this->getTranslationAPI()->__('The type, accessible from the root, that resolves mutations', 'graphql-server'),
            'subscriptionType' => $this->getTranslationAPI()->__('The type, accessible from the root, that resolves subscriptions', 'graphql-server'),
            'types' => $this->getTranslationAPI()->__('All types registered in the data graph', 'graphql-server'),
            'directives' => $this->getTranslationAPI()->__('All directives registered in the data graph', 'graphql-server'),
            'type' => $this->getTranslationAPI()->__('Obtain a specific type from the schema', 'graphql-server'),
            default => parent::getFieldDescription($objectTypeResolver, $fieldName),
        };
    }

    public function getFieldArgNameTypeResolvers(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): array
    {
        return match ($fieldName) {
            'type' => [
                'name' => $this->getStringScalarTypeResolver(),
            ],
            default => parent::getFieldArgNameTypeResolvers($objectTypeResolver, $fieldName),
        };
    }

    public function getFieldArgDescription(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName, string $fieldArgName): ?string
    {
        return match ([$fieldName => $fieldArgName]) {
            ['type' => 'name'] => $this->getTranslationAPI()->__('The name of the type', 'graphql-server'),
            default => parent::getFieldArgDescription($objectTypeResolver, $fieldName, $fieldArgName),
        };
    }

    public function getFieldArgTypeModifiers(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName, string $fieldArgName): int
    {
        return match ([$fieldName => $fieldArgName]) {
            ['type' => 'name'] => SchemaTypeModifiers::MANDATORY,
            default => parent::getFieldArgTypeModifiers($objectTypeResolver, $fieldName, $fieldArgName),
        };
    }

    /**
     * @param array<string, mixed> $fieldArgs
     * @param array<string, mixed>|null $variables
     * @param array<string, mixed>|null $expressions
     * @param array<string, mixed> $options
     */
    public function resolveValue(
        ObjectTypeResolverInterface $objectTypeResolver,
        object $object,
        string $fieldName,
        array $fieldArgs = [],
        ?array $variables = null,
        ?array $expressions = null,
        array $options = []
    ): mixed {
        /** @var Schema */
        $schema = $object;
        return match ($fieldName) {
            'queryType' => $schema->getQueryRootObjectTypeID(),
            'mutationType' => $schema->getMutationRootObjectTypeID(),
            'subscriptionType' => $schema->getSubscriptionRootObjectTypeID(),
            'types' => $schema->getTypeIDs(),
            'directives' => $schema->getDirectiveIDs(),
            'type' => $schema->getTypeID($fieldArgs['name']),
            default => parent::resolveValue($objectTypeResolver, $object, $fieldName, $fieldArgs, $variables, $expressions, $options),
        };
    }

    public function getFieldTypeResolver(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): ConcreteTypeResolverInterface
    {
        return match ($fieldName) {
            'queryType', 'mutationType', 'subscriptionType', 'types', 'type' => $this->getTypeObjectTypeResolver(),
            'directives' => $this->getDirectiveObjectTypeResolver(),
            default => parent::getFieldTypeResolver($objectTypeResolver, $fieldName),
        };
    }
}
