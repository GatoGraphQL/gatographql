<?php

declare(strict_types=1);

namespace PoPCMSSchema\CategoryMutations\MutationResolvers;

use PoPCMSSchema\SchemaCommons\MutationResolvers\AbstractBulkOperationDecoratorMutationResolver;
use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;

class UpdateGenericCategoryTermBulkOperationMutationResolver extends AbstractBulkOperationDecoratorMutationResolver
{
    private ?UpdateGenericCategoryTermMutationResolver $updateGenericCategoryTermMutationResolver = null;

    final public function setUpdateGenericCategoryTermMutationResolver(UpdateGenericCategoryTermMutationResolver $updateGenericCategoryTermMutationResolver): void
    {
        $this->updateGenericCategoryTermMutationResolver = $updateGenericCategoryTermMutationResolver;
    }
    final protected function getUpdateGenericCategoryTermMutationResolver(): UpdateGenericCategoryTermMutationResolver
    {
        if ($this->updateGenericCategoryTermMutationResolver === null) {
            /** @var UpdateGenericCategoryTermMutationResolver */
            $updateGenericCategoryTermMutationResolver = $this->instanceManager->getInstance(UpdateGenericCategoryTermMutationResolver::class);
            $this->updateGenericCategoryTermMutationResolver = $updateGenericCategoryTermMutationResolver;
        }
        return $this->updateGenericCategoryTermMutationResolver;
    }

    protected function getDecoratedOperationMutationResolver(): MutationResolverInterface
    {
        return $this->getUpdateGenericCategoryTermMutationResolver();
    }
}
