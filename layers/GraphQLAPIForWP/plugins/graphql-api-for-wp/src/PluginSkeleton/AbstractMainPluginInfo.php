<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\PluginSkeleton;

use GraphQLAPI\GraphQLAPI\PluginEnvironment;

abstract class AbstractMainPluginInfo extends AbstractPluginInfo implements MainPluginInfoInterface
{
    protected function initialize(): void
    {
        parent::initialize();
        
        /**
         * Where to store the config cache,
         * for both /container and /operational
         * (config persistent cache: component model configuration + schema)
         */
        $this->values['cache-dir'] = PluginEnvironment::getCacheDir();
    }

    public function getCacheDir(): string
    {
        return $this->values['cache-dir'];
    }
}
