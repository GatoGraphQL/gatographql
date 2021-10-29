<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\Services\Blocks\AccessControlRuleBlocks;

use GraphQLAPI\GraphQLAPI\Services\BlockCategories\AccessControlBlockCategory;
use GraphQLAPI\GraphQLAPI\Services\BlockCategories\BlockCategoryInterface;
use GraphQLAPI\GraphQLAPI\Services\Blocks\AbstractBlock;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Access Control rule block
 */
abstract class AbstractAccessControlRuleBlock extends AbstractBlock
{
    public const ATTRIBUTE_NAME_ACCESS_CONTROL_GROUP = 'accessControlGroup';
    public const ATTRIBUTE_NAME_VALUE = 'value';

    private ?AccessControlBlockCategory $accessControlBlockCategory = null;

    public function setAccessControlBlockCategory(AccessControlBlockCategory $accessControlBlockCategory): void
    {
        $this->accessControlBlockCategory = $accessControlBlockCategory;
    }
    protected function getAccessControlBlockCategory(): AccessControlBlockCategory
    {
        return $this->accessControlBlockCategory ??= $this->getInstanceManager()->getInstance(AccessControlBlockCategory::class);
    }

    protected function getBlockCategory(): ?BlockCategoryInterface
    {
        return $this->getAccessControlBlockCategory();
    }
}
