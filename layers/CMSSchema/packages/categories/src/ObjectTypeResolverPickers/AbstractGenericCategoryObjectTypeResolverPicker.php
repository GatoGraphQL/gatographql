<?php

declare(strict_types=1);

namespace PoPCMSSchema\Categories\ObjectTypeResolverPickers;

use PoPCMSSchema\Categories\Module;
use PoPCMSSchema\Categories\ModuleConfiguration;
use PoPCMSSchema\Categories\Registries\CategoryObjectTypeResolverPickerRegistryInterface;
use PoPCMSSchema\Categories\TypeAPIs\CategoryTypeAPIInterface;
use PoPCMSSchema\Categories\TypeResolvers\ObjectType\GenericCategoryObjectTypeResolver;
use PoP\ComponentModel\App;
use PoP\ComponentModel\ObjectTypeResolverPickers\AbstractObjectTypeResolverPicker;
use PoP\ComponentModel\TypeResolvers\ObjectType\ObjectTypeResolverInterface;

abstract class AbstractGenericCategoryObjectTypeResolverPicker extends AbstractObjectTypeResolverPicker implements CategoryObjectTypeResolverPickerInterface
{
    private ?GenericCategoryObjectTypeResolver $genericCategoryObjectTypeResolver = null;
    private ?CategoryTypeAPIInterface $categoryTypeAPI = null;
    private ?CategoryObjectTypeResolverPickerRegistryInterface $categoryObjectTypeResolverPickerRegistry = null;

    final public function setGenericCategoryObjectTypeResolver(GenericCategoryObjectTypeResolver $genericCategoryObjectTypeResolver): void
    {
        $this->genericCategoryObjectTypeResolver = $genericCategoryObjectTypeResolver;
    }
    final protected function getGenericCategoryObjectTypeResolver(): GenericCategoryObjectTypeResolver
    {
        /** @var GenericCategoryObjectTypeResolver */
        return $this->genericCategoryObjectTypeResolver ??= $this->instanceManager->getInstance(GenericCategoryObjectTypeResolver::class);
    }
    final public function setCategoryTypeAPI(CategoryTypeAPIInterface $categoryTypeAPI): void
    {
        $this->categoryTypeAPI = $categoryTypeAPI;
    }
    final protected function getCategoryTypeAPI(): CategoryTypeAPIInterface
    {
        /** @var CategoryTypeAPIInterface */
        return $this->categoryTypeAPI ??= $this->instanceManager->getInstance(CategoryTypeAPIInterface::class);
    }
    final public function setCategoryObjectTypeResolverPickerRegistry(CategoryObjectTypeResolverPickerRegistryInterface $categoryObjectTypeResolverPickerRegistry): void
    {
        $this->categoryObjectTypeResolverPickerRegistry = $categoryObjectTypeResolverPickerRegistry;
    }
    final protected function getCategoryObjectTypeResolverPickerRegistry(): CategoryObjectTypeResolverPickerRegistryInterface
    {
        /** @var CategoryObjectTypeResolverPickerRegistryInterface */
        return $this->categoryObjectTypeResolverPickerRegistry ??= $this->instanceManager->getInstance(CategoryObjectTypeResolverPickerRegistryInterface::class);
    }

    public function getObjectTypeResolver(): ObjectTypeResolverInterface
    {
        return $this->getGenericCategoryObjectTypeResolver();
    }

    public function isInstanceOfType(object $object): bool
    {
        return $this->getCategoryTypeAPI()->isInstanceOfCategoryType($object);
    }

    public function isIDOfType(string|int $objectID): bool
    {
        return $this->getCategoryTypeAPI()->categoryExists($objectID);
    }

    /**
     * Process last, as to allow specific Pickers to take precedence,
     * such as for PostCategory. Only when no other Picker is available,
     * will GenericCategory be used.
     */
    public function getPriorityToAttachToClasses(): int
    {
        return 0;
    }

    /**
     * Check if there are generic custom post types,
     * and only then enable it
     */
    public function isServiceEnabled(): bool
    {
        $categoryObjectTypeResolverPickers = $this->getCategoryObjectTypeResolverPickerRegistry()->getCategoryObjectTypeResolverPickers();
        $nonGenericCategoryTypes = [];
        foreach ($categoryObjectTypeResolverPickers as $categoryObjectTypeResolverPicker) {
            // Skip this class, we're interested in all the non-generic ones
            if ($categoryObjectTypeResolverPicker === $this) {
                continue;
            }
            $nonGenericCategoryTypes[] = $categoryObjectTypeResolverPicker->getCategoryTaxonomy();
        }

        /** @var ModuleConfiguration */
        $moduleConfiguration = App::getModule(Module::class)->getConfiguration();
        return array_diff(
            $moduleConfiguration->getQueryableCategoryTaxonomies(),
            $nonGenericCategoryTypes
        ) !== [];
    }
    
    /**
     * Return empty value is OK, because this method will
     * never be called on this class.
     *
     * @see `isServiceEnabled`
     */
    public function getCategoryTaxonomy(): string
    {
        return '';
    }
}
