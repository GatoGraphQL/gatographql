<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\Services\Scripts;

use GraphQLAPI\GraphQLAPI\App;

/**
 * Trait to set common functions for a Gutenberg block for this plugin (GraphQL API)
 */
trait MainPluginScriptTrait
{
    protected function getPluginDir(): string
    {
        return \GraphQLAPI\GraphQLAPI\PluginApp::getMainPlugin()->getPluginDir();
    }

    protected function getPluginURL(): string
    {
        // Remove the trailing slash
        return trim(\GraphQLAPI\GraphQLAPI\PluginApp::getMainPlugin()->getPluginURL(), '/');
    }
}
