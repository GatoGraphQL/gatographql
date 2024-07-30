<?php

declare(strict_types=1);

namespace PoPCMSSchema\CategoryMutations\TypeResolvers\UnionType;

use PoPCMSSchema\CategoryMutations\TypeResolvers\UnionType\AbstractRootUpdateCategoryMutationErrorPayloadUnionTypeResolver;
use PoPCMSSchema\CategoryMutations\RelationalTypeDataLoaders\UnionType\RootUpdateGenericCategoryTermMutationErrorPayloadUnionTypeDataLoader;
use PoP\ComponentModel\RelationalTypeDataLoaders\RelationalTypeDataLoaderInterface;

class RootUpdateGenericCategoryTermMutationErrorPayloadUnionTypeResolver extends AbstractRootUpdateCategoryMutationErrorPayloadUnionTypeResolver
{
    private ?RootUpdateGenericCategoryTermMutationErrorPayloadUnionTypeDataLoader $rootUpdateGenericCategoryTermMutationErrorPayloadUnionTypeDataLoader = null;

    final public function setRootUpdateGenericCategoryTermMutationErrorPayloadUnionTypeDataLoader(RootUpdateGenericCategoryTermMutationErrorPayloadUnionTypeDataLoader $rootUpdateGenericCategoryTermMutationErrorPayloadUnionTypeDataLoader): void
    {
        $this->rootUpdateGenericCategoryTermMutationErrorPayloadUnionTypeDataLoader = $rootUpdateGenericCategoryTermMutationErrorPayloadUnionTypeDataLoader;
    }
    final protected function getRootUpdateGenericCategoryTermMutationErrorPayloadUnionTypeDataLoader(): RootUpdateGenericCategoryTermMutationErrorPayloadUnionTypeDataLoader
    {
        if ($this->rootUpdateGenericCategoryTermMutationErrorPayloadUnionTypeDataLoader === null) {
            /** @var RootUpdateGenericCategoryTermMutationErrorPayloadUnionTypeDataLoader */
            $rootUpdateGenericCategoryTermMutationErrorPayloadUnionTypeDataLoader = $this->instanceManager->getInstance(RootUpdateGenericCategoryTermMutationErrorPayloadUnionTypeDataLoader::class);
            $this->rootUpdateGenericCategoryTermMutationErrorPayloadUnionTypeDataLoader = $rootUpdateGenericCategoryTermMutationErrorPayloadUnionTypeDataLoader;
        }
        return $this->rootUpdateGenericCategoryTermMutationErrorPayloadUnionTypeDataLoader;
    }

    public function getTypeName(): string
    {
        return 'RootUpdateCategoryTermMutationErrorPayloadUnion';
    }

    public function getTypeDescription(): ?string
    {
        return $this->__('Union of \'Error Payload\' types when updating a category term', 'post-mutations');
    }

    public function getRelationalTypeDataLoader(): RelationalTypeDataLoaderInterface
    {
        return $this->getRootUpdateGenericCategoryTermMutationErrorPayloadUnionTypeDataLoader();
    }
}
