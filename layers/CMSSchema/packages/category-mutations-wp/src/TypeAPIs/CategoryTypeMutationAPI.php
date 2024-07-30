<?php

declare(strict_types=1);

namespace PoPCMSSchema\CategoryMutationsWP\TypeAPIs;

use PoPCMSSchema\CategoryMutations\Exception\CategoryTermCRUDMutationException;
use PoPCMSSchema\CategoryMutations\TypeAPIs\CategoryTypeMutationAPIInterface;
use PoPCMSSchema\TaxonomyMutationsWP\TypeAPIs\TaxonomyTypeMutationAPI;

use WP_Error;

/**
 * Methods to interact with the Type, to be implemented by the underlying CMS
 */
class CategoryTypeMutationAPI extends TaxonomyTypeMutationAPI implements CategoryTypeMutationAPIInterface
{
    /**
     * @param array<string,mixed> $data
     * @return string|int the ID of the created category
     * @throws CategoryTermCRUDMutationException If there was an error (eg: some taxonomy term creation validation failed)
     */
    public function createCategoryTerm(array $data): string|int
    {
        return $this->createTaxonomyTerm($data);
    }

    protected function createTaxonomyTermCRUDMutationException(WP_Error $wpError): CategoryTermCRUDMutationException
    {
        return new CategoryTermCRUDMutationException(
            $wpError->get_error_message(),
            $wpError->get_error_code() ? $wpError->get_error_code() : null,
            $this->getWPErrorData($wpError),
        );
    }

    /**
     * @param array<string,mixed> $data
     * @return string|int the ID of the updated category
     * @throws CategoryTermCRUDMutationException If there was an error (eg: taxonomy term does not exist)
     */
    public function updateCategoryTerm(array $data): string|int
    {
        return $this->updateTaxonomyTerm($data);
    }
}