<?php

class PoP_Application_TaxonomyQuery_ConfigurationUtils
{
    public static function enableFilterAllcontentByTaxonomy()
    {
        return \PoP\Root\App::getHookManager()->applyFilters('PoP_Application_ConfigurationUtils:enable-filter-allcontent-by-taxonomy', false);
    }
}
