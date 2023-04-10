<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\State;

use GraphQLAPI\GraphQLAPI\Services\EndpointExecuters\GraphQLEndpointExecuterInterface;
use PoPAPI\API\Response\Schemes as APISchemes;
use PoPAPI\GraphQLAPI\DataStructureFormatters\GraphQLDataStructureFormatter;
use PoP\Root\App;
use PoP\Root\State\AbstractAppStateProvider;

abstract class AbstractGraphQLEndpointExecuterAppStateProvider extends AbstractAppStateProvider
{
    private ?GraphQLDataStructureFormatter $graphQLDataStructureFormatter = null;

    final public function setGraphQLDataStructureFormatter(GraphQLDataStructureFormatter $graphQLDataStructureFormatter): void
    {
        $this->graphQLDataStructureFormatter = $graphQLDataStructureFormatter;
    }
    final protected function getGraphQLDataStructureFormatter(): GraphQLDataStructureFormatter
    {
        /** @var GraphQLDataStructureFormatter */
        return $this->graphQLDataStructureFormatter ??= $this->instanceManager->getInstance(GraphQLDataStructureFormatter::class);
    }

    abstract protected function getGraphQLEndpointExecuter(): GraphQLEndpointExecuterInterface;

    public function isServiceEnabled(): bool
    {
        return $this->getGraphQLEndpointExecuter()->isServiceEnabled();
    }

    /**
     * Watch out! This logic is now being superseded by
     * `$appLoader->setInitialAppState($graphQLRequestAppState);`
     * in AbstractMainPlugin. However, it has not been removed
     * as there's no harm, and it provides a backup solution.
     *
     * Due to that same code, ?output=json is being set always.
     * As ->doingJSON can't then be used anymore, here the new
     * state "executing-graphql" is added.
     *
     * @see layers/GraphQLAPIForWP/plugins/graphql-api-for-wp/src/PluginSkeleton/AbstractMainPlugin.php
     * @see layers/Engine/packages/engine-wp/src/Hooks/TemplateHookSet.php
     *
     * @param array<string,mixed> $state
     */
    public function initialize(array &$state): void
    {
        $state['scheme'] = APISchemes::API;
        $state['datastructure'] = $this->getGraphQLDataStructureFormatter()->getName();

        /**
         * Artificial state, to signify that this is indeed
         * a GraphQL request.
         */
        $state['executing-graphql'] = true;
    }

    /**
     * @param array<string,mixed> $state
     */
    public function consolidate(array &$state): void
    {
        /**
         * Get the query and variables from the implementing class
         */
        list(
            $graphQLQuery,
            $graphQLVariables
        ) = $this->getGraphQLEndpointExecuter()->getGraphQLQueryAndVariables(App::getState(['routing', 'queried-object']));
        if ($graphQLQuery === null) {
            // If there is no query, nothing to do!
            return;
        }

        $state['query'] = $graphQLQuery;

        /**
         * Merge the variables into $state?
         *
         * Normally, GraphQL variables must not override the variables from the request
         * But this behavior can be overriden for the persisted query,
         * by setting "Accept Variables as URL Params" => false
         * When editing in the editor, 'queried-object' will be null, and that's OK
         */
        $graphQLVariables ??= [];
        $state['variables'] = $this->getGraphQLEndpointExecuter()->doURLParamsOverrideGraphQLVariables(App::getState(['routing', 'queried-object'])) ?
            array_merge(
                $graphQLVariables,
                $state['variables'] ?? []
            ) :
            array_merge(
                $state['variables'] ?? [],
                $graphQLVariables
            );
    }
}
