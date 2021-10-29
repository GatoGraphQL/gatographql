<?php

declare(strict_types=1);

namespace PoPSitesWassup\SocialNetworkMutations\MutationResolverBridges;

use PoP\ApplicationTaxonomies\FunctionAPIFactory;
use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
use PoPSchema\PostTags\TypeAPIs\PostTagTypeAPIInterface;
use PoPSitesWassup\SocialNetworkMutations\MutationResolvers\UnsubscribeFromTagMutationResolver;
use Symfony\Contracts\Service\Attribute\Required;

class UnsubscribeFromTagMutationResolverBridge extends AbstractTagUpdateUserMetaValueMutationResolverBridge
{
    private ?UnsubscribeFromTagMutationResolver $unsubscribeFromTagMutationResolver = null;
    private ?PostTagTypeAPIInterface $postTagTypeAPI = null;

    public function setUnsubscribeFromTagMutationResolver(UnsubscribeFromTagMutationResolver $unsubscribeFromTagMutationResolver): void
    {
        $this->unsubscribeFromTagMutationResolver = $unsubscribeFromTagMutationResolver;
    }
    protected function getUnsubscribeFromTagMutationResolver(): UnsubscribeFromTagMutationResolver
    {
        return $this->unsubscribeFromTagMutationResolver ??= $this->instanceManager->getInstance(UnsubscribeFromTagMutationResolver::class);
    }
    public function setPostTagTypeAPI(PostTagTypeAPIInterface $postTagTypeAPI): void
    {
        $this->postTagTypeAPI = $postTagTypeAPI;
    }
    protected function getPostTagTypeAPI(): PostTagTypeAPIInterface
    {
        return $this->postTagTypeAPI ??= $this->instanceManager->getInstance(PostTagTypeAPIInterface::class);
    }

    public function getMutationResolver(): MutationResolverInterface
    {
        return $this->getUnsubscribeFromTagMutationResolver();
    }

    protected function onlyExecuteWhenDoingPost(): bool
    {
        return false;
    }

    public function getSuccessString(string | int $result_id): ?string
    {
        $applicationtaxonomyapi = FunctionAPIFactory::getInstance();
        $tag = $this->getPostTagTypeAPI()->getTag($result_id);
        return sprintf(
            $this->translationAPI->__('You have unsubscribed from <em><strong>%s</strong></em>.', 'pop-coreprocessors'),
            $applicationtaxonomyapi->getTagSymbolName($tag)
        );
    }
}
