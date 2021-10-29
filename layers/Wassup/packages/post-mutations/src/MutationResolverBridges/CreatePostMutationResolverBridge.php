<?php

declare(strict_types=1);

namespace PoPSitesWassup\PostMutations\MutationResolverBridges;

use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
use PoPSitesWassup\PostMutations\MutationResolvers\CreatePostMutationResolver;
use Symfony\Contracts\Service\Attribute\Required;

class CreatePostMutationResolverBridge extends AbstractCreateUpdatePostMutationResolverBridge
{
    private ?CreatePostMutationResolver $createPostMutationResolver = null;

    public function setCreatePostMutationResolver(CreatePostMutationResolver $createPostMutationResolver): void
    {
        $this->createPostMutationResolver = $createPostMutationResolver;
    }
    protected function getCreatePostMutationResolver(): CreatePostMutationResolver
    {
        return $this->createPostMutationResolver ??= $this->getInstanceManager()->getInstance(CreatePostMutationResolver::class);
    }

    public function getMutationResolver(): MutationResolverInterface
    {
        return $this->getCreatePostMutationResolver();
    }

    protected function isUpdate(): bool
    {
        return false;
    }
}
