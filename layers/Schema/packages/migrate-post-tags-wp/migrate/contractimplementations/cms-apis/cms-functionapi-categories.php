<?php

namespace PoPSchema\PostCategories\WP;

use PoPSchema\CategoriesWP\TypeAPIs\AbstractCategoryTypeAPI;
use PoPSchema\PostCategories\Facades\PostCategoryTypeAPIFacade;

class FunctionAPI extends AbstractCategoryTypeAPI implements \PoPSchema\PostCategories\FunctionAPI
{
    public function __construct()
    {
        \PoPSchema\PostCategories\FunctionAPIFactory::setInstance($this);
    }

    /**
     * Implement this function by the actual service
     */
    protected function getTaxonomyName(): string
    {
        $postCategoryTypeAPI = PostCategoryTypeAPIFacade::getInstance();
        return $postCategoryTypeAPI->getPostCategoryTaxonomyName();
    }
    /**
     * Implement this function by the actual service
     */
    protected function getCategoryBaseOption(): string
    {
        return 'category_base';
    }
}

/**
 * Initialize
 */
new FunctionAPI();
