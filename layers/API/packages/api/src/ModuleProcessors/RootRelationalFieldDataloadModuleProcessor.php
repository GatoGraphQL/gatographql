<?php

declare(strict_types=1);

namespace PoP\API\ModuleProcessors;

use PoP\ComponentModel\TypeResolvers\RelationalTypeResolverInterface;
use PoP\Engine\ObjectModels\Root;
use PoP\Engine\Schema\SchemaDefinitionServiceInterface;
use Symfony\Contracts\Service\Attribute\Required;

class RootRelationalFieldDataloadModuleProcessor extends AbstractRelationalFieldDataloadModuleProcessor
{
    public const MODULE_DATALOAD_RELATIONALFIELDS_ROOT = 'dataload-relationalfields-root';
    
    protected SchemaDefinitionServiceInterface $schemaDefinitionService;

    #[Required]
    final public function autowireRootRelationalFieldDataloadModuleProcessor(
        SchemaDefinitionServiceInterface $schemaDefinitionService,
    ): void {
        $this->schemaDefinitionService = $schemaDefinitionService;
    }

    public function getModulesToProcess(): array
    {
        return array(
            [self::class, self::MODULE_DATALOAD_RELATIONALFIELDS_ROOT],
        );
    }

    public function getObjectIDOrIDs(array $module, array &$props, &$data_properties): string | int | array
    {
        switch ($module[1]) {
            case self::MODULE_DATALOAD_RELATIONALFIELDS_ROOT:
                return Root::ID;
        }
        return parent::getObjectIDOrIDs($module, $props, $data_properties);
    }

    public function getRelationalTypeResolver(array $module): ?RelationalTypeResolverInterface
    {
        switch ($module[1]) {
            case self::MODULE_DATALOAD_RELATIONALFIELDS_ROOT:
                return $this->schemaDefinitionService->getRootObjectTypeResolver();
        }

        return parent::getRelationalTypeResolver($module);
    }
}
