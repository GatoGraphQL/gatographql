<?php

declare(strict_types=1);

namespace PHPUnitForGatoGraphQL\GatoGraphQLTesting\Executers;

use GatoGraphQL\GatoGraphQL\App;
use GatoGraphQL\GatoGraphQL\AppHelpers;
use GatoGraphQL\GatoGraphQL\PluginAppHooks;
use GatoGraphQL\GatoGraphQL\PluginSkeleton\PluginLifecyclePriorities;
use PHPUnitForGatoGraphQL\GatoGraphQLTesting\Constants\Actions;
use PoP\Root\Constants\HookNames;

class WPCronTestExecuter
{
    /**
     * Inject the "internal-graphql-server-response" state
     * containing the response of the same requested query
     * via the endpoint, but executed against `GraphQLServer`.
     */
    public function __construct()
    {
        \add_action(
            PluginAppHooks::INITIALIZE_APP,
            $this->addHooks(...),
            PluginLifecyclePriorities::INITIALIZE_APP
        );
    }

    public function addHooks(string $pluginAppGraphQLServerName): void
    {
        App::addAction(
            HookNames::APPLICATION_READY,
            $this->maybeExecuteWPCron(...)
        );
    }

    public function maybeExecuteWPCron(): void
    {
        if (!AppHelpers::isMainAppThread()) {
            return;
        }

        /** @var string[] */
        $actions = App::getState('actions');
        if (!in_array(Actions::TEST_WP_CRON, $actions)) {
            return;
        }

        $timestamp = 888888888;
        $this->executeWPCron($timestamp);
    }

    protected function executeWPCron(int $timestamp): void
    {
        if (!\wp_next_scheduled('gato_graphql__execute_query')) {
            $postTitle = sprintf(
                'Post created with wp-cron with timestamp %s',
                $timestamp
            );
            \wp_schedule_event(
                time(),
                'weekly',
                'gato_graphql__execute_query',
                [
                    <<<GRAPHQL
                    mutation CreateTrashedPostWithUniqueSlug(
                        $postTitle: String!
                    ) {
                        createPost(input:{
                            title: $postTitle
                            status: trash
                        }) {
                            status
                        }
                    }
                    GRAPHQL,
                    [
                        'postTitle' => $postTitle
                    ]
                ]
            );
        } else {
            $timestamp = \wp_next_scheduled( 'gato_graphql__execute_query');
            \wp_unschedule_event($timestamp, 'gato_graphql__execute_query');
        }
    }
}
