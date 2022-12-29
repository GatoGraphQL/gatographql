<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\Services\Taxonomies;

use GraphQLAPI\GraphQLAPI\Services\CustomPostTypes\GraphQLCustomEndpointCustomPostType;
use GraphQLAPI\GraphQLAPI\Services\CustomPostTypes\GraphQLPersistedQueryEndpointCustomPostType;
use PoP\Root\Facades\Instances\InstanceManagerFacade;
use PoP\Root\Services\StandaloneServiceTrait;

class GraphQLQueryCategoryTaxonomy extends AbstractCategory
{
    use StandaloneServiceTrait;
    
    private ?GraphQLPersistedQueryEndpointCustomPostType $graphQLPersistedQueryEndpointCustomPostType = null;
    private ?GraphQLCustomEndpointCustomPostType $graphQLCustomEndpointCustomPostType = null;

    final public function setGraphQLPersistedQueryEndpointCustomPostType(GraphQLPersistedQueryEndpointCustomPostType $graphQLPersistedQueryEndpointCustomPostType): void
    {
        $this->graphQLPersistedQueryEndpointCustomPostType = $graphQLPersistedQueryEndpointCustomPostType;
    }
    final protected function getGraphQLPersistedQueryEndpointCustomPostType(): GraphQLPersistedQueryEndpointCustomPostType
    {
        /** @var GraphQLPersistedQueryEndpointCustomPostType */
        return $this->graphQLPersistedQueryEndpointCustomPostType ??= InstanceManagerFacade::getInstance()->getInstance(GraphQLPersistedQueryEndpointCustomPostType::class);
    }
    final public function setGraphQLCustomEndpointCustomPostType(GraphQLCustomEndpointCustomPostType $graphQLCustomEndpointCustomPostType): void
    {
        $this->graphQLCustomEndpointCustomPostType = $graphQLCustomEndpointCustomPostType;
    }
    final protected function getGraphQLCustomEndpointCustomPostType(): GraphQLCustomEndpointCustomPostType
    {
        /** @var GraphQLCustomEndpointCustomPostType */
        return $this->graphQLCustomEndpointCustomPostType ??= InstanceManagerFacade::getInstance()->getInstance(GraphQLCustomEndpointCustomPostType::class);
    }

    public function getTaxonomy(): string
    {
        return 'graphql-category';
    }

    public function getTaxonomyName(bool $titleCase = true): string
    {
        return $titleCase ? \__('Category', 'graphql-api') : \__('category', 'graphql-api');
    }

    /**
     * @param bool $titleCase Indicate if the name must be title case (for starting a sentence) or, otherwise, lowercase
     */
    protected function getTaxonomyPluralNames(bool $titleCase = true): string
    {
        return $titleCase ? \__('Categories', 'graphql-api') : \__('categories', 'graphql-api');
    }

    /**
     * @return string[]
     */
    protected function getCustomPostTypes(): array
    {
        return [
            $this->getGraphQLPersistedQueryEndpointCustomPostType()->getCustomPostType(),
            $this->getGraphQLCustomEndpointCustomPostType()->getCustomPostType(),
        ];
    }
}
