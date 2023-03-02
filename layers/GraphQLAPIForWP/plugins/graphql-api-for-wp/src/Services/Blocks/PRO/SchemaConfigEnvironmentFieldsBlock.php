<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\Services\Blocks\PRO;

use GraphQLAPI\GraphQLAPI\Services\Blocks\PRO\ExtensionBlockTrait;
use GraphQLAPI\GraphQLAPIPRO\ModuleResolvers\SchemaTypeModuleResolver;
use GraphQLAPI\GraphQLAPI\Services\Blocks\AbstractSchemaConfigSchemaAllowAccessToEntriesBlock;
use GraphQLAPI\GraphQLAPI\Services\Blocks\OptionsBlockTrait;

class SchemaConfigEnvironmentFieldsBlock extends AbstractSchemaConfigSchemaAllowAccessToEntriesBlock
{
    use PROPluginBlockTrait;
    use OptionsBlockTrait;

    protected function getBlockName(): string
    {
        return 'schema-config-environment-fields';
    }

    public function getBlockPriority(): int
    {
        return 2000;
    }

    public function getEnablingModule(): ?string
    {
        return SchemaTypeModuleResolver::ENVIRONMENT_FIELDS;
    }

    protected function getBlockTitle(): string
    {
        return \__('Environment Fields', 'graphql-api-pro');
    }

    protected function getRenderBlockLabel(): string
    {
        return $this->__('Allowed environment variables and constants', 'graphql-api-pro');
    }

    /**
     * Register style-index.css
     */
    protected function registerCommonStyleCSS(): bool
    {
        return true;
    }

    /**
     * Add the locale language to the localized data?
     */
    protected function addLocalLanguage(): bool
    {
        return true;
    }

    /**
     * Default language for the script/component's documentation
     */
    protected function getDefaultLanguage(): ?string
    {
        // English
        return 'en';
    }
}
