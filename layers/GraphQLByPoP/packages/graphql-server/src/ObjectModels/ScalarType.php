<?php

declare(strict_types=1);

namespace GraphQLByPoP\GraphQLServer\ObjectModels;

use GraphQLByPoP\GraphQLServer\ObjectModels\AbstractType;
use GraphQLByPoP\GraphQLServer\ObjectModels\NonDocumentableTypeTrait;

class ScalarType extends AbstractType
{
    use NonDocumentableTypeTrait;
    protected string $name;

    
    #[\Symfony\Contracts\Service\Attribute\Required]
    public function autowireScalarType(
        array &$fullSchemaDefinition,
        array $schemaDefinitionPath,
        string $name,
        array $customDefinition = []
    ) {
        $this->name = $name;
        parent::__construct($fullSchemaDefinition, $schemaDefinitionPath, $customDefinition);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getKind(): string
    {
        return TypeKinds::SCALAR;
    }
}
