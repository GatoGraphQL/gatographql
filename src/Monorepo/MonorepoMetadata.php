<?php

declare(strict_types=1);

namespace PoP\PoP\Monorepo;

final class MonorepoMetadata
{
    /**
     * Modify this const when bumping the code to a new version.
     *
     * Important: Do not modify the formatting of this PHP code!
     * A regex will search for this exact pattern, to update the
     * version in the ReleaseWorker when deploying for PROD.
     */
    final public const VERSION = '1.0.7';

    final public const GIT_BASE_BRANCH = 'master';
    final public const GIT_USER_NAME = 'leoloso';
    final public const GIT_USER_EMAIL = 'leo@getpop.org';
}
