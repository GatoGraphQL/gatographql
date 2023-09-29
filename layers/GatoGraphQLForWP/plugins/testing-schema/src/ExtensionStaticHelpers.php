<?php

declare(strict_types=1);

namespace GatoGraphQL\TestingSchema;

use GatoGraphQL\GatoGraphQL\PluginApp;
use GatoGraphQL\GatoGraphQL\StaticHelpers\PluginVersionHelpers;

class ExtensionStaticHelpers
{
    public static function getGitHubRepoDocsRootURL(): string
    {
        return 'https://raw.githubusercontent.com/GatoGraphQL/GatoGraphQL';
    }

    public static function getGitHubRepoDocsRootPathURL(): string
    {
        $extensionPluginVersion = PluginApp::getExtension(GatoGraphQLExtension::class)->getPluginVersion();
        $tag = PluginVersionHelpers::isDevelopmentVersion($extensionPluginVersion)
            ? ExtensionMetadata::GIT_BASE_BRANCH
            : $extensionPluginVersion;
        return static::getGitHubRepoDocsRootURL() . '/' . $tag . '/layers/GatoGraphQLForWP/plugins/testing-schema/';
    }
}
