<?php

declare(strict_types=1);

namespace PoP\AccessControl\RelationalTypeResolverDecorators;

use PoP\AccessControl\Services\AccessControlGroups;

class DisableAccessConfigurableAccessControlForFieldsInPublicSchemaRelationalTypeResolverDecorator extends AbstractDisableAccessConfigurableAccessControlForFieldsInPublicSchemaRelationalTypeResolverDecorator
{
    protected function getConfigurationEntries(): array
    {
        return $this->getAccessControlManager()->getEntriesForFields(AccessControlGroups::DISABLED);
    }
}
