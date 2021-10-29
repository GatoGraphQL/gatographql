<?php

declare(strict_types=1);

namespace PoPSitesWassup\SocialNetworkMutations\MutationResolverBridges;

use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
use PoPSitesWassup\SocialNetworkMutations\MutationResolvers\UndoDownvoteCustomPostMutationResolver;
use Symfony\Contracts\Service\Attribute\Required;

class UndoDownvoteCustomPostMutationResolverBridge extends AbstractCustomPostUpdateUserMetaValueMutationResolverBridge
{
    private ?UndoDownvoteCustomPostMutationResolver $undoDownvoteCustomPostMutationResolver = null;

    public function setUndoDownvoteCustomPostMutationResolver(UndoDownvoteCustomPostMutationResolver $undoDownvoteCustomPostMutationResolver): void
    {
        $this->undoDownvoteCustomPostMutationResolver = $undoDownvoteCustomPostMutationResolver;
    }
    protected function getUndoDownvoteCustomPostMutationResolver(): UndoDownvoteCustomPostMutationResolver
    {
        return $this->undoDownvoteCustomPostMutationResolver ??= $this->getInstanceManager()->getInstance(UndoDownvoteCustomPostMutationResolver::class);
    }

    public function getMutationResolver(): MutationResolverInterface
    {
        return $this->getUndoDownvoteCustomPostMutationResolver();
    }

    protected function onlyExecuteWhenDoingPost(): bool
    {
        return false;
    }

    public function getSuccessString(string | int $result_id): ?string
    {
        return sprintf(
            $this->getTranslationAPI()->__('You have stopped down-voting <em><strong>%s</strong></em>.', 'pop-coreprocessors'),
            $this->getCustomPostTypeAPI()->getTitle($result_id)
        );
    }
}
