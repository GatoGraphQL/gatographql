<?php

declare(strict_types=1);

namespace PoPCMSSchema\SchemaCommons;

use PoP\Root\Module\AbstractComponent;

/**
 * Initialize component
 */
class Module extends AbstractComponent
{
    protected function requiresSatisfyingComponent(): bool
    {
        return true;
    }

    /**
     * Classes from PoP components that must be initialized before this component
     *
     * @return string[]
     */
    public function getDependedComponentClasses(): array
    {
        return [
            \PoPSchema\SchemaCommons\Module::class,
        ];
    }

    /**
     * Initialize services
     *
     * @param string[] $skipSchemaComponentClasses
     */
    protected function initializeContainerServices(
        bool $skipSchema,
        array $skipSchemaComponentClasses,
    ): void {
        $this->initServices(dirname(__DIR__));
        $this->initSchemaServices(dirname(__DIR__), $skipSchema);
    }
}
