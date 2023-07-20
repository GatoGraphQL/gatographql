<?php

declare(strict_types=1);

namespace PHPUnitForGatoGraphQL\GatoGraphQL\Integration;

use GatoGraphQL\GatoGraphQL\ModuleResolvers\SchemaTypeModuleResolver;

abstract class AbstractTreatCustomEndpointRawContentFieldsAsPrivateDataModifyPluginSettingsFixtureEndpointWebserverRequestTestCase extends AbstractModifyPluginSettingsFixtureEndpointWebserverRequestTestCase
{
    protected static function getFixtureFolder(): string
    {
        return __DIR__ . '/fixture-custom-post-raw-content-fields-as-sensitive-data';
    }

    protected function getSettingsKey(): string
    {
        return SchemaTypeModuleResolver::OPTION_TREAT_CUSTOMPOST_RAW_CONTENT_FIELDS_AS_SENSITIVE_DATA;
    }

    protected function getModuleID(string $dataName): string
    {
        return 'gatographql_gatographql_schema-customposts';
    }

    protected function getPluginSettingsNewValue(): mixed
    {
        return false;
    }
}
