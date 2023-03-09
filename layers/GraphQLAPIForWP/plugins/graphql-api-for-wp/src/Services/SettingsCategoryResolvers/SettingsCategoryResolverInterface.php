<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\Services\SettingsCategoryResolvers;

interface SettingsCategoryResolverInterface
{
    /**
     * @return string[]
     */
    public function getSettingsCategoriesToResolve(): array;

    public function getDescription(string $settingsCategory): ?string;

    public function getDBOptionName(string $settingsCategory): string;
}
