<?php

declare(strict_types=1);

namespace PoP\AccessControl\RelationalTypeResolverDecorators;

use PoP\ComponentModel\Instances\InstanceManagerInterface;
use PoP\AccessControl\Services\AccessControlManagerInterface;
use PoP\ComponentModel\Schema\FieldQueryInterpreterInterface;
use PoP\AccessControl\RelationalTypeResolverDecorators\ConfigurableAccessControlForFieldsRelationalTypeResolverDecoratorTrait;

abstract class AbstractConfigurableAccessControlForFieldsInPrivateSchemaRelationalTypeResolverDecorator extends AbstractPrivateSchemaRelationalTypeResolverDecorator
{
    use ConfigurableAccessControlForFieldsRelationalTypeResolverDecoratorTrait;
    protected AccessControlManagerInterface $accessControlManager;

    
    #[\Symfony\Contracts\Service\Attribute\Required]
    public function autowireAbstractConfigurableAccessControlForFieldsInPrivateSchemaRelationalTypeResolverDecorator(
        AccessControlManagerInterface $accessControlManager,
    ) {
        $this->accessControlManager = $accessControlManager;
    }
}
