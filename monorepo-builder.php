<?php

declare(strict_types=1);

use PoP\PoP\Extensions\Symplify\MonorepoBuilder\ValueObject\Option as CustomOption;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\AddTagToChangelogReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\PushNextDevReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\PushTagReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\SetCurrentMutualDependenciesReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\SetNextMutualDependenciesReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\TagVersionReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\UpdateBranchAliasReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\UpdateReplaceReleaseWorker;
use Symplify\MonorepoBuilder\ValueObject\Option;
use Symplify\PackageBuilder\Neon\NeonPrinter;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();

    $packagePathOrganizations = [
        'layers/Engine/packages' => 'getpop',
        'layers/API/packages' => 'getpop',
        'layers/Schema/packages' => 'PoPSchema',
        'layers/GraphQLByPoP/packages' => 'GraphQLByPoP',
        'layers/GraphQLAPIForWP/packages' => 'GraphQLAPI',
        'layers/GraphQLAPIForWP/plugins' => 'GraphQLAPI',
        'layers/SiteBuilder/packages' => 'getpop',
        'layers/Wassup/packages' => 'PoPSites-Wassup',
    ];
    $parameters->set(CustomOption::PACKAGE_ORGANIZATIONS, $packagePathOrganizations);
    $parameters->set(Option::PACKAGE_DIRECTORIES, array_map(
        function (string $packagePath): string {
            return __DIR__ . '/' . $packagePath;
        },
        array_keys($packagePathOrganizations)
    ));
    $parameters->set(Option::PACKAGE_DIRECTORIES_EXCLUDES, [
        'graphql-api-for-wp/wordpress',
    ]);

    /**
     * Plugins to generate
     */
    $parameters->set(CustomOption::PLUGIN_CONFIG_ENTRIES, [
        // GraphQL API for WordPress
        [
            'path' => 'layers/GraphQLAPIForWP/plugins/graphql-api-for-wp',
            'zip_file' => 'graphql-api.zip',
            'main_file' => 'graphql-api.php',
            'exclude_files' => 'dev-helpers/\* docs/images/\*',
            'dist_repo_organization' => 'GraphQLAPI',
            'dist_repo_name' => 'graphql-api-for-wp-dist',
            'additional_rector_configs' => [
                __DIR__ . '/ci/downgrades/rector-downgrade-code-graphql-api-hacks-CacheItem.php',
                __DIR__ . '/ci/downgrades/rector-downgrade-code-graphql-api-hacks-ArrowFnMixedType.php',
                __DIR__ . '/ci/downgrades/rector-downgrade-code-graphql-api-hacks-ArrowFnUnionType.php',
            ],
            'rector_downgrade_config' => __DIR__ . '/ci/downgrades/rector-downgrade-code-graphql-api.php',
            'scoping' => [
                'phpscoper_config' => __DIR__ . '/ci/scoping/scoper-graphql-api.inc.php',
                'rector_test_config' => __DIR__ . '/ci/scoping/rector-test-scoping-graphql-api.php',
            ],
        ],
        // GraphQL API - Extension Demo
        [
            'path' => 'layers/GraphQLAPIForWP/plugins/extension-demo',
            'zip_file' => 'graphql-api-extension-demo.zip',
            'main_file' => 'graphql-api-extension-demo.php',
            'exclude_files' => 'docs/images/\*',
            'dist_repo_organization' => 'GraphQLAPI',
            'dist_repo_name' => 'extension-demo-dist',
            'rector_downgrade_config' => __DIR__ . '/ci/downgrades/rector-downgrade-code-extension-demo.php',
        ],
    ]);

    /**
     * Additional downgrade Rector configs:
     * Hack to fix bugs
     * @see https://github.com/rectorphp/rector/issues/5962
     * @see https://github.com/leoloso/PoP/issues/597#issue-855005786
     */
    $parameters->set(CustomOption::ADDITIONAL_DOWNGRADE_RECTOR_CONFIGS, [
        __DIR__ . '/ci/downgrades/rector-downgrade-code-hacks-CacheItem.php',
        __DIR__ . '/ci/downgrades/rector-downgrade-code-hacks-ArrowFnMixedType.php',
        __DIR__ . '/ci/downgrades/rector-downgrade-code-hacks-ArrowFnUnionType.php',
    ]);

    // Temporary hack! PHPStan is currently failing for these packages,
    // because they have not been fully converted to PSR-4 (WIP),
    // and converting them will take some time. Hence, for the time being,
    // skip them from executing PHPStan, to avoid the CI from failing
    $unmigratedFailingPackages = [
        'layers/Engine/packages/access-control',
        'layers/API/packages/api',
        'layers/API/packages/api-mirrorquery',
        'layers/SiteBuilder/packages/application',
        'layers/Schema/packages/block-metadata-for-wp',
        'layers/Schema/packages/categories',
        'layers/Wassup/packages/comment-mutations',
        'layers/Schema/packages/comment-mutations',
        'layers/Schema/packages/comment-mutations-wp',
        'layers/Schema/packages/comments',
        'layers/Engine/packages/component-model',
        'layers/SiteBuilder/packages/component-model-configuration',
        'layers/Wassup/packages/contactus-mutations',
        'layers/Wassup/packages/contactuser-mutations',
        'layers/Wassup/packages/custompost-mutations',
        'layers/Wassup/packages/custompostlink-mutations',
        'layers/Schema/packages/custompostmedia',
        'layers/Schema/packages/customposts',
        'layers/Engine/packages/engine',
        'layers/Engine/packages/engine-wp',
        'layers/Schema/packages/everythingelse',
        'layers/Wassup/packages/everythingelse-mutations',
        'layers/Schema/packages/everythingelse-wp',
        // 'layers/Misc/packages/examples-for-pop',
        'layers/Wassup/packages/flag-mutations',
        'layers/Wassup/packages/form-mutations',
        'layers/Schema/packages/generic-customposts',
        // 'layers/Schema/packages/google-translate-directive-for-customposts',
        'layers/GraphQLByPoP/packages/graphql-server',
        'layers/Wassup/packages/gravityforms-mutations',
        'layers/Engine/packages/guzzle-helpers',
        'layers/Wassup/packages/highlight-mutations',
        'layers/Schema/packages/highlights',
        'layers/Schema/packages/highlights-wp',
        'layers/Schema/packages/media',
        'layers/Schema/packages/menus',
        'layers/Schema/packages/menus-wp',
        'layers/SiteBuilder/packages/multisite',
        'layers/Wassup/packages/newsletter-mutations',
        'layers/Wassup/packages/notification-mutations',
        'layers/Schema/packages/notifications',
        'layers/Schema/packages/pages',
        'layers/Wassup/packages/post-mutations',
        'layers/Schema/packages/post-tags',
        'layers/Schema/packages/post-categories',
        'layers/Wassup/packages/postlink-mutations',
        'layers/Schema/packages/posts',
        'layers/Schema/packages/posts-wp',
        // 'layers/GraphQLAPIForWP/plugins/schema-feedback',
        'layers/GraphQLAPIForWP/plugins/graphql-api-for-wp',
        'layers/Wassup/packages/share-mutations',
        'layers/SiteBuilder/packages/site',
        'layers/SiteBuilder/packages/site-wp',
        'layers/Wassup/packages/socialnetwork-mutations',
        'layers/Wassup/packages/stance-mutations',
        'layers/Schema/packages/stances',
        'layers/Schema/packages/stances-wp',
        'layers/Wassup/packages/system-mutations',
        'layers/Schema/packages/tags',
        'layers/Schema/packages/categories',
        'layers/Schema/packages/user-roles-wp',
        'layers/Schema/packages/user-state-mutations',
        'layers/Wassup/packages/user-state-mutations',
        'layers/Schema/packages/users',
        'layers/Wassup/packages/volunteer-mutations',
        'layers/Wassup/packages/wassup',
        'layers/SiteBuilder/packages/application-wp',
        'layers/SiteBuilder/packages/definitionpersistence',
        'layers/SiteBuilder/packages/definitions-base36',
        'layers/SiteBuilder/packages/definitions-emoji',
        'layers/SiteBuilder/packages/resourceloader',
        'layers/SiteBuilder/packages/resources',
        'layers/SiteBuilder/packages/spa',
        'layers/SiteBuilder/packages/static-site-generator',
    ];
    $parameters->set(CustomOption::UNMIGRATED_FAILING_PACKAGES, $unmigratedFailingPackages);

    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::DATA_TO_REMOVE, [
        'require-dev' => [
            // 'phpunit/phpunit' => '*',
            'wpackagist-plugin/block-metadata' => '*',
        ],
        // 'minimum-stability' => 'dev',
        // 'prefer-stable' => true,
    ]);

    // Install also the monorepo-builder! So it can be used in CI
    $parameters->set(Option::DATA_TO_APPEND, [
        'require-dev' => [
            'symplify/monorepo-builder' => '^9.0',
        ],
        'autoload' => [
            'psr-4' => [
                'PoP\\PoP\\'=> 'src',
            ],
        ],
        // 'extra' => [
        //     'installer-paths' => [
        //         'wordpress/wp-content/plugins/{$name}/' => [
        //             'type:wordpress-plugin',
        //         ]
        //     ]
        // ],
    ]);

    $services = $containerConfigurator->services();
    $services->defaults()
        ->autowire()
        ->autoconfigure();

    /** Set all services */
    $services
        ->set(NeonPrinter::class) // Required to inject into PHPStanNeonContentProvider
        ->load('PoP\\PoP\\', 'src/*');

    /** release workers - in order to execute */
    $services->set(UpdateReplaceReleaseWorker::class);
    $services->set(SetCurrentMutualDependenciesReleaseWorker::class);
    $services->set(AddTagToChangelogReleaseWorker::class);
    $services->set(TagVersionReleaseWorker::class);
    $services->set(PushTagReleaseWorker::class);
    $services->set(SetNextMutualDependenciesReleaseWorker::class);
    $services->set(UpdateBranchAliasReleaseWorker::class);
    $services->set(PushNextDevReleaseWorker::class);
};
