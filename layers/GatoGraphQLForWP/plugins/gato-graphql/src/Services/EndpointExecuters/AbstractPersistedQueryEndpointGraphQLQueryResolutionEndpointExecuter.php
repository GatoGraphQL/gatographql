<?php

declare(strict_types=1);

namespace GatoGraphQL\GatoGraphQL\Services\EndpointExecuters;

use GatoGraphQL\GatoGraphQL\ObjectModels\NullableGraphQLQueryVariablesEntry;
use GatoGraphQL\GatoGraphQL\Services\Blocks\PersistedQueryEndpointOptionsBlock;
use GatoGraphQL\GatoGraphQL\Services\Helpers\GraphQLQueryPostTypeHelpers;
use WP_Post;

abstract class AbstractPersistedQueryEndpointGraphQLQueryResolutionEndpointExecuter extends AbstractGraphQLQueryResolutionEndpointExecuter
{
    private ?GraphQLQueryPostTypeHelpers $graphQLQueryPostTypeHelpers = null;

    final public function setGraphQLQueryPostTypeHelpers(GraphQLQueryPostTypeHelpers $graphQLQueryPostTypeHelpers): void
    {
        $this->graphQLQueryPostTypeHelpers = $graphQLQueryPostTypeHelpers;
    }
    final protected function getGraphQLQueryPostTypeHelpers(): GraphQLQueryPostTypeHelpers
    {
        /** @var GraphQLQueryPostTypeHelpers */
        return $this->graphQLQueryPostTypeHelpers ??= $this->instanceManager->getInstance(GraphQLQueryPostTypeHelpers::class);
    }

    /**
     * Provide the query to execute and its variables
     */
    public function getGraphQLQueryAndVariables(?WP_Post $graphQLQueryPost): NullableGraphQLQueryVariablesEntry
    {
        /**
         * Extract the query from the post (or from its parents), and set it in the application state
         */
        $graphQLQueryPostAttributes = $this->getGraphQLQueryPostTypeHelpers()->getGraphQLQueryPostAttributes($graphQLQueryPost, true);
        return new NullableGraphQLQueryVariablesEntry(
            $graphQLQueryPostAttributes->query,
            $graphQLQueryPostAttributes->variables,
        );
    }

    /**
     * Indicate if the GraphQL variables must override the URL params
     */
    public function doURLParamsOverrideGraphQLVariables(?WP_Post $customPost): bool
    {
        if ($customPost === null) {
            return parent::doURLParamsOverrideGraphQLVariables($customPost);
        }
        $default = true;
        $optionsBlockDataItem = $this->getCustomPostType()->getOptionsBlockDataItem($customPost);
        if ($optionsBlockDataItem === null) {
            return $default;
        }

        // `true` is the default option in Gutenberg, so it's not saved to the DB!
        return $optionsBlockDataItem['attrs'][PersistedQueryEndpointOptionsBlock::ATTRIBUTE_NAME_ACCEPT_VARIABLES_AS_URL_PARAMS] ?? $default;
    }
}
