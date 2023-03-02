<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\Services\Blocks\PRO;

use GraphQLAPI\GraphQLAPI\Services\BlockCategories\BlockCategoryInterface;
use GraphQLAPI\GraphQLAPI\Services\BlockCategories\SchemaConfigurationBlockCategory;
use GraphQLAPI\GraphQLAPI\Services\Blocks\AbstractBlock;
use GraphQLAPI\GraphQLAPI\Services\Blocks\SchemaConfigEditorBlockServiceTagInterface;

abstract class AbstractSchemaConfigPlaceholderBlock extends AbstractBlock implements SchemaConfigEditorBlockServiceTagInterface
{
    private ?SchemaConfigurationBlockCategory $schemaConfigurationBlockCategory = null;

    final public function setSchemaConfigurationBlockCategory(SchemaConfigurationBlockCategory $schemaConfigurationBlockCategory): void
    {
        $this->schemaConfigurationBlockCategory = $schemaConfigurationBlockCategory;
    }
    final protected function getSchemaConfigurationBlockCategory(): SchemaConfigurationBlockCategory
    {
        /** @var SchemaConfigurationBlockCategory */
        return $this->schemaConfigurationBlockCategory ??= $this->instanceManager->getInstance(SchemaConfigurationBlockCategory::class);
    }

    // protected function isDynamicBlock(): bool
    // {
    //     return true;
    // }

    protected function getBlockCategory(): ?BlockCategoryInterface
    {
        return $this->getSchemaConfigurationBlockCategory();
    }

    public function getBlockPriority(): int
    {
        return 10;
    }
}
