<?php

declare(strict_types=1);

namespace PoPCMSSchema\CategoryMutations\TypeResolvers\InputObjectType;

class CategoryTermUpdateInputObjectTypeResolver extends AbstractCreateOrUpdateCategoryTermInputObjectTypeResolver implements UpdateCategoryTermInputObjectTypeResolverInterface
{
    public function getTypeName(): string
    {
        return 'CategoryUpdateInput';
    }

    public function getTypeDescription(): ?string
    {
        return $this->__('Input to update a taxonomy term', 'taxonomy-mutations');
    }

    protected function addTaxonomyInputField(): bool
    {
        return false;
    }
}
