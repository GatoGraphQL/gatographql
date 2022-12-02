<?php

declare(strict_types=1);

namespace PoPCMSSchema\PostMutations\TypeResolvers\UnionType;

use PoPCMSSchema\PostMutations\RelationalTypeDataLoaders\UnionType\RootUpdatePostMutationErrorPayloadUnionTypeDataLoader;
use PoP\ComponentModel\RelationalTypeDataLoaders\RelationalTypeDataLoaderInterface;

class RootUpdatePostMutationErrorPayloadUnionTypeResolver extends AbstractPostMutationErrorPayloadUnionTypeResolver
{
    private ?RootUpdatePostMutationErrorPayloadUnionTypeDataLoader $rootUpdatePostMutationErrorPayloadUnionTypeDataLoader = null;

    final public function setRootUpdatePostMutationErrorPayloadUnionTypeDataLoader(RootUpdatePostMutationErrorPayloadUnionTypeDataLoader $rootUpdatePostMutationErrorPayloadUnionTypeDataLoader): void
    {
        $this->rootUpdatePostMutationErrorPayloadUnionTypeDataLoader = $rootUpdatePostMutationErrorPayloadUnionTypeDataLoader;
    }
    final protected function getRootUpdatePostMutationErrorPayloadUnionTypeDataLoader(): RootUpdatePostMutationErrorPayloadUnionTypeDataLoader
    {
        /** @var RootUpdatePostMutationErrorPayloadUnionTypeDataLoader */
        return $this->rootUpdatePostMutationErrorPayloadUnionTypeDataLoader ??= $this->instanceManager->getInstance(RootUpdatePostMutationErrorPayloadUnionTypeDataLoader::class);
    }

    public function getTypeName(): string
    {
        return 'RootUpdatePostMutationErrorPayloadUnion';
    }

    public function getTypeDescription(): ?string
    {
        return $this->__('Union of \'Error Payload\' types when updating a post', 'post-mutations');
    }

    public function getRelationalTypeDataLoader(): RelationalTypeDataLoaderInterface
    {
        return $this->getRootUpdatePostMutationErrorPayloadUnionTypeDataLoader();
    }
}
