<?php

declare(strict_types=1);

namespace PoPSchema\PostMutations\MutationResolvers;

use PoP\Hooks\HooksAPIInterface;
use PoP\LooseContracts\NameResolverInterface;
use PoP\Translation\TranslationAPIInterface;
use PoPSchema\CustomPostMutations\MutationResolvers\AbstractCreateUpdateCustomPostMutationResolver;
use PoPSchema\CustomPostMutations\TypeAPIs\CustomPostTypeMutationAPIInterface;
use PoPSchema\CustomPosts\TypeAPIs\CustomPostTypeAPIInterface;
use PoPSchema\CustomPosts\TypeResolvers\EnumType\CustomPostStatusEnumTypeResolver;
use PoPSchema\Posts\TypeAPIs\PostTypeAPIInterface;
use PoPSchema\UserRoles\TypeAPIs\UserRoleTypeAPIInterface;

abstract class AbstractCreateUpdatePostMutationResolver extends AbstractCreateUpdateCustomPostMutationResolver
{
    protected PostTypeAPIInterface $postTypeAPI;
    
    #[\Symfony\Contracts\Service\Attribute\Required]
    public function autowireAbstractCreateUpdatePostMutationResolver(
        PostTypeAPIInterface $postTypeAPI,
    ) {
        $this->postTypeAPI = $postTypeAPI;
    }

    public function getCustomPostType(): string
    {
        return $this->postTypeAPI->getPostCustomPostType();
    }
}
