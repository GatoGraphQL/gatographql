<?php

declare(strict_types=1);

require_once __DIR__ . '/scoper-shared.inc.php';

use Isolated\Symfony\Component\Finder\Finder;
use PoP\Root\Helpers\ScopingHelpers;

// Load code from the plugin to make the logic DRY
require_once dirname(__DIR__, 4) . '/layers/Engine/packages/root/src/Constants/Scoping.php';
require_once dirname(__DIR__, 4) . '/layers/Engine/packages/root/src/Helpers/ScopingHelpers.php';

/**
 * Scope own classes for creating a standalone plugin.
 *
 * Whitelisting classes to scope is not supported by PHP-Scoper:
 *
 * @see https://github.com/humbug/php-scoper/issues/378#issuecomment-687601833
 *
 * Then, instead, create a regex that excludes all classes except
 * the ones we're looking for.
 *
 * Notice this must be executed in all the local source code
 * and local packages.
 */
$pluginName = 'Gato GraphQL';
return [
    'prefix' => ScopingHelpers::getPluginInternalScopingTopLevelNamespace($pluginName),
    'finders' => [
        Finder::create()
            ->files()
            ->ignoreVCS(true)
            ->notName('/.*\\.md|.*\\.dist|composer\\.lock/')
            ->exclude([
                'tests',
            ])
            ->notPath([
                /**
                 * For some reason it also prefixes content in file:
                 *   vendor/symfony/dependency-injection/Dumper/PhpDumper.php
                 * and a few more, so directly exclude all other libraries.
                 */
                '#vendor/guzzlehttp/#',
                '#vendor/jrfnl/#',
                '#vendor/league/#',
                '#vendor/masterminds/#',
                '#vendor/michelf/#',
                '#vendor/psr/#',
                '#vendor/ralouphie/#',
                '#vendor/symfony/#',
            ])
            // ->path(
            //     // Include own source and own libraries only
            //     '#^src/|^vendor/[getpop|gatographql|graphql\-by\-pop|pop\-api|pop\-backbone|pop\-cms\-schema|pop\-schema|pop\-wp\-schema]/#',
            // )
            ->in(convertRelativeToFullPath()),
    ],
    'exclude-namespaces' => [
        // Own namespaces
        // Watch out! Do NOT alter the order of PoPSchema, PoPWPSchema and PoP!
        // If PoP comes first, then PoPSchema is still scoped!
        '/^(?!.*(PoPAPI|PoPBackbone|PoPCMSSchema|PoPIncludes|PoPSchema|PoPWPSchema|PoP|GraphQLByPoP|GatoGraphQL))/',
    ],
];
