<?php

declare(strict_types=1);

namespace PoPSchema\CustomPosts\TypeDataLoaders;

use PoP\ComponentModel\TypeDataLoaders\AbstractTypeQueryableDataLoader;
use PoPSchema\CustomPosts\Facades\CustomPostTypeAPIFacade;
use PoPSchema\CustomPostsWP\TypeAPIs\CustomPostTypeAPIUtils;
use PoPSchema\SchemaCommons\DataLoading\ReturnTypes;
use PoPSchema\SchemaCommons\Constants\QueryOptions;

abstract class AbstractCustomPostTypeDataLoader extends AbstractTypeQueryableDataLoader
{
    public function getDataFromIdsQuery(array $ids): array
    {
        $customPostTypeAPI = CustomPostTypeAPIFacade::getInstance();
        return [
            'include' => $ids,
            'status' => CustomPostTypeAPIUtils::getPostStatuses(),
            // If not adding the post types, WordPress only uses "post", so querying by CPT would fail loading data
            // This should be considered for the CMS-agnostic case if it makes sense
            'custompost-types' => $customPostTypeAPI->getCustomPostTypes([
                'publicly-queryable' => true,
            ])
        ];
    }

    public function executeQuery($query, array $options = []): array
    {
        $customPostTypeAPI = CustomPostTypeAPIFacade::getInstance();
        return $customPostTypeAPI->getCustomPosts($query, $options);
    }

    protected function getOrderbyDefault()
    {
        return $this->nameResolver->getName('popcms:dbcolumn:orderby:customposts:date');
    }

    protected function getOrderDefault()
    {
        return 'DESC';
    }

    public function executeQueryIds($query): array
    {
        $options = [
            QueryOptions::RETURN_TYPE => ReturnTypes::IDS,
        ];
        return $this->executeQuery($query, $options);
    }

    protected function getLimitParam($query_args)
    {
        return $this->hooksAPI->applyFilters(
            'CustomPostTypeDataLoader:query:limit',
            parent::getLimitParam($query_args)
        );
    }

    protected function getQueryHookName()
    {
        // Allow to add the timestamp for loadingLatest
        return 'CustomPostTypeDataLoader:query';
    }
}
