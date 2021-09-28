<?php

declare(strict_types=1);

namespace GraphQLByPoP\GraphQLServer\TypeResolvers\ObjectType;

use PoP\ComponentModel\Engine\DataloadingEngineInterface;
use PoP\ComponentModel\AttachableExtensions\AttachableExtensionManagerInterface;
use PoP\ComponentModel\DirectivePipeline\DirectivePipelineServiceInterface;
use PoP\Translation\TranslationAPIInterface;
use PoP\Hooks\HooksAPIInterface;
use PoP\ComponentModel\Instances\InstanceManagerInterface;
use PoP\ComponentModel\Schema\SchemaNamespacingServiceInterface;
use PoP\ComponentModel\Schema\SchemaDefinitionServiceInterface;
use PoP\ComponentModel\Schema\FeedbackMessageStoreInterface;
use PoP\ComponentModel\Schema\FieldQueryInterpreterInterface;
use PoP\ComponentModel\ErrorHandling\ErrorProviderInterface;
use PoP\ComponentModel\RelationalTypeDataLoaders\RelationalTypeDataLoaderInterface;
use GraphQLByPoP\GraphQLServer\ObjectModels\InputValue;
use GraphQLByPoP\GraphQLServer\RelationalTypeDataLoaders\ObjectType\SchemaDefinitionReferenceTypeDataLoader;
use GraphQLByPoP\GraphQLServer\TypeResolvers\ObjectType\AbstractIntrospectionObjectTypeResolver;

class InputValueObjectTypeResolver extends AbstractIntrospectionObjectTypeResolver
{
    protected SchemaDefinitionReferenceTypeDataLoader $schemaDefinitionReferenceTypeDataLoader;
    
    #[\Symfony\Contracts\Service\Attribute\Required]
    public function autowireInputValueObjectTypeResolver(
        SchemaDefinitionReferenceTypeDataLoader $schemaDefinitionReferenceTypeDataLoader,
    ) {
        $this->schemaDefinitionReferenceTypeDataLoader = $schemaDefinitionReferenceTypeDataLoader;
    }

    public function getTypeName(): string
    {
        return '__InputValue';
    }

    public function getSchemaTypeDescription(): ?string
    {
        return $this->translationAPI->__('Representation of an input object in GraphQL', 'graphql-server');
    }

    public function getID(object $object): string | int | null
    {
        /** @var InputValue */
        $inputValue = $object;
        return $inputValue->getID();
    }

    public function getRelationalTypeDataLoader(): RelationalTypeDataLoaderInterface
    {
        return $this->schemaDefinitionReferenceTypeDataLoader;
    }
}
