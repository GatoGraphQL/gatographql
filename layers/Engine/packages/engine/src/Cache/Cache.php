<?php

declare(strict_types=1);

namespace PoP\Engine\Cache;

use PoP\ComponentModel\Cache\Cache as UpstreamCache;
use Psr\Cache\CacheItemInterface;
use Symfony\Contracts\Service\Attribute\Required;

class Cache extends UpstreamCache
{
    #[Required]
    final public function autowireInitializeCache(): void
    {
        // When a plugin is activated/deactivated, ANY plugin, delete the corresponding cached files
        // This is particularly important for the MEMORY, since we can't set by constants to not use it
        $this->getHooksAPI()->addAction(
            'popcms:componentInstalledOrUninstalled',
            function (): void {
                $this->cacheItemPool->clear();
            }
        );

        // Save all deferred cacheItems
        $this->getHooksAPI()->addAction(
            'popcms:shutdown',
            function (): void {
                $this->cacheItemPool->commit();
            }
        );
    }

    /**
     * Override to save as deferred, on hook "popcms:shutdown"
     */
    protected function saveCache(CacheItemInterface $cacheItem): void
    {
        $this->cacheItemPool->saveDeferred($cacheItem);
    }
}
