<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\Services\Blocks;

use GraphQLAPI\GraphQLAPI\Services\BlockCategories\BlockCategoryInterface;
use GraphQLAPI\GraphQLAPI\Services\BlockCategories\CustomEndpointBlockCategory;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Endpoint Options block
 */
class CustomEndpointOptionsBlock extends AbstractEndpointOptionsBlock implements EndpointEditorBlockServiceTagInterface
{
    use MainPluginBlockTrait;

    private ?CustomEndpointBlockCategory $customEndpointBlockCategory = null;

    public function setCustomEndpointBlockCategory(CustomEndpointBlockCategory $customEndpointBlockCategory): void
    {
        $this->customEndpointBlockCategory = $customEndpointBlockCategory;
    }
    protected function getCustomEndpointBlockCategory(): CustomEndpointBlockCategory
    {
        return $this->customEndpointBlockCategory ??= $this->getInstanceManager()->getInstance(CustomEndpointBlockCategory::class);
    }

    protected function getBlockName(): string
    {
        return 'custom-endpoint-options';
    }

    public function getBlockPriority(): int
    {
        return 160;
    }

    protected function getBlockCategory(): ?BlockCategoryInterface
    {
        return $this->getCustomEndpointBlockCategory();
    }
}
