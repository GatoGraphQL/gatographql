<?php

declare(strict_types=1);

namespace PoPSchema\QueriedObject\TypeResolvers\Interface;

use PoP\ComponentModel\TypeResolvers\Interface\AbstractInterfaceTypeResolver;

class QueryableInterfaceTypeResolver extends AbstractInterfaceTypeResolver
{
    public function getTypeName(): string
    {
        return 'Queryable';
    }

    public function getSchemaTypeDescription(): ?string
    {
        return $this->translationAPI->__('Entities that can be queried through an URL', 'queriedobject');
    }
}
