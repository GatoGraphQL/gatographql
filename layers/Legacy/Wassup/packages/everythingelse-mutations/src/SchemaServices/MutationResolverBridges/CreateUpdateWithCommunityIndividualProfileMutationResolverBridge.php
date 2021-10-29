<?php

declare(strict_types=1);

namespace PoPSitesWassup\EverythingElseMutations\SchemaServices\MutationResolverBridges;

use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
use PoPSitesWassup\EverythingElseMutations\SchemaServices\MutationResolvers\CreateUpdateWithCommunityIndividualProfileMutationResolver;
use Symfony\Contracts\Service\Attribute\Required;

class CreateUpdateWithCommunityIndividualProfileMutationResolverBridge extends CreateUpdateIndividualProfileMutationResolverBridge
{
    private ?CreateUpdateWithCommunityIndividualProfileMutationResolver $createUpdateWithCommunityIndividualProfileMutationResolver = null;
    
    public function setCreateUpdateWithCommunityIndividualProfileMutationResolver(CreateUpdateWithCommunityIndividualProfileMutationResolver $createUpdateWithCommunityIndividualProfileMutationResolver): void
    {
        $this->createUpdateWithCommunityIndividualProfileMutationResolver = $createUpdateWithCommunityIndividualProfileMutationResolver;
    }
    protected function getCreateUpdateWithCommunityIndividualProfileMutationResolver(): CreateUpdateWithCommunityIndividualProfileMutationResolver
    {
        return $this->createUpdateWithCommunityIndividualProfileMutationResolver ??= $this->getInstanceManager()->getInstance(CreateUpdateWithCommunityIndividualProfileMutationResolver::class);
    }
    
    public function getMutationResolver(): MutationResolverInterface
    {
        return $this->getCreateUpdateWithCommunityIndividualProfileMutationResolver();
    }
}
