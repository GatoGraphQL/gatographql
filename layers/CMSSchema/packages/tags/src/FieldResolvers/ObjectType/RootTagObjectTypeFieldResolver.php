<?php

declare(strict_types=1);

namespace PoPCMSSchema\Tags\FieldResolvers\ObjectType;

use PoPCMSSchema\SchemaCommons\DataLoading\ReturnTypes;
use PoPCMSSchema\SchemaCommons\Resolvers\WithLimitFieldArgResolverTrait;
use PoPCMSSchema\Tags\TypeAPIs\TaxonomyTagListTypeAPIInterface;
use PoPCMSSchema\Tags\TypeResolvers\EnumType\TagTaxonomyEnumTypeResolver;
use PoPCMSSchema\Tags\TypeResolvers\InputObjectType\RootTagsFilterInputObjectTypeResolver;
use PoPCMSSchema\Tags\TypeResolvers\InputObjectType\TagByInputObjectTypeResolver;
use PoPCMSSchema\Tags\TypeResolvers\InputObjectType\TagPaginationInputObjectTypeResolver;
use PoPCMSSchema\Tags\TypeResolvers\UnionType\TagUnionTypeResolver;
use PoPCMSSchema\Taxonomies\TypeResolvers\InputObjectType\TaxonomySortInputObjectTypeResolver;
use PoPSchema\SchemaCommons\Constants\QueryOptions;
use PoP\ComponentModel\Feedback\ObjectTypeFieldResolutionFeedbackStore;
use PoP\ComponentModel\FieldResolvers\ObjectType\AbstractQueryableObjectTypeFieldResolver;
use PoP\ComponentModel\QueryResolution\FieldDataAccessorInterface;
use PoP\ComponentModel\Schema\SchemaTypeModifiers;
use PoP\ComponentModel\TypeResolvers\ConcreteTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\InputTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\ObjectType\ObjectTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\ScalarType\IntScalarTypeResolver;
use PoP\ComponentModel\TypeResolvers\ScalarType\StringScalarTypeResolver;
use PoP\Engine\TypeResolvers\ObjectType\RootObjectTypeResolver;

class RootTagObjectTypeFieldResolver extends AbstractQueryableObjectTypeFieldResolver
{
    use WithLimitFieldArgResolverTrait;

    private ?IntScalarTypeResolver $intScalarTypeResolver = null;
    private ?StringScalarTypeResolver $stringScalarTypeResolver = null;
    private ?TagUnionTypeResolver $tagUnionTypeResolver = null;
    private ?TaxonomyTagListTypeAPIInterface $taxonomyTagListTypeAPI = null;
    private ?TagByInputObjectTypeResolver $tagByInputObjectTypeResolver = null;
    private ?TagTaxonomyEnumTypeResolver $tagTaxonomyEnumTypeResolver = null;
    private ?TagPaginationInputObjectTypeResolver $tagPaginationInputObjectTypeResolver = null;
    private ?TaxonomySortInputObjectTypeResolver $taxonomySortInputObjectTypeResolver = null;
    private ?RootTagsFilterInputObjectTypeResolver $rootTagsFilterInputObjectTypeResolver = null;

    final public function setIntScalarTypeResolver(IntScalarTypeResolver $intScalarTypeResolver): void
    {
        $this->intScalarTypeResolver = $intScalarTypeResolver;
    }
    final protected function getIntScalarTypeResolver(): IntScalarTypeResolver
    {
        /** @var IntScalarTypeResolver */
        return $this->intScalarTypeResolver ??= $this->instanceManager->getInstance(IntScalarTypeResolver::class);
    }
    final public function setStringScalarTypeResolver(StringScalarTypeResolver $stringScalarTypeResolver): void
    {
        $this->stringScalarTypeResolver = $stringScalarTypeResolver;
    }
    final protected function getStringScalarTypeResolver(): StringScalarTypeResolver
    {
        /** @var StringScalarTypeResolver */
        return $this->stringScalarTypeResolver ??= $this->instanceManager->getInstance(StringScalarTypeResolver::class);
    }
    final public function setTagUnionTypeResolver(TagUnionTypeResolver $tagUnionTypeResolver): void
    {
        $this->tagUnionTypeResolver = $tagUnionTypeResolver;
    }
    final protected function getTagUnionTypeResolver(): TagUnionTypeResolver
    {
        /** @var TagUnionTypeResolver */
        return $this->tagUnionTypeResolver ??= $this->instanceManager->getInstance(TagUnionTypeResolver::class);
    }
    final public function setTaxonomyTagListTypeAPI(TaxonomyTagListTypeAPIInterface $taxonomyTagListTypeAPI): void
    {
        $this->taxonomyTagListTypeAPI = $taxonomyTagListTypeAPI;
    }
    final protected function getTaxonomyTagListTypeAPI(): TaxonomyTagListTypeAPIInterface
    {
        /** @var TaxonomyTagListTypeAPIInterface */
        return $this->taxonomyTagListTypeAPI ??= $this->instanceManager->getInstance(TaxonomyTagListTypeAPIInterface::class);
    }
    final public function setTagByInputObjectTypeResolver(TagByInputObjectTypeResolver $tagByInputObjectTypeResolver): void
    {
        $this->tagByInputObjectTypeResolver = $tagByInputObjectTypeResolver;
    }
    final protected function getTagByInputObjectTypeResolver(): TagByInputObjectTypeResolver
    {
        /** @var TagByInputObjectTypeResolver */
        return $this->tagByInputObjectTypeResolver ??= $this->instanceManager->getInstance(TagByInputObjectTypeResolver::class);
    }
    final public function setTagTaxonomyEnumTypeResolver(TagTaxonomyEnumTypeResolver $tagTaxonomyEnumTypeResolver): void
    {
        $this->tagTaxonomyEnumTypeResolver = $tagTaxonomyEnumTypeResolver;
    }
    final protected function getTagTaxonomyEnumTypeResolver(): TagTaxonomyEnumTypeResolver
    {
        /** @var TagTaxonomyEnumTypeResolver */
        return $this->tagTaxonomyEnumTypeResolver ??= $this->instanceManager->getInstance(TagTaxonomyEnumTypeResolver::class);
    }
    final public function setTagPaginationInputObjectTypeResolver(TagPaginationInputObjectTypeResolver $tagPaginationInputObjectTypeResolver): void
    {
        $this->tagPaginationInputObjectTypeResolver = $tagPaginationInputObjectTypeResolver;
    }
    final protected function getTagPaginationInputObjectTypeResolver(): TagPaginationInputObjectTypeResolver
    {
        /** @var TagPaginationInputObjectTypeResolver */
        return $this->tagPaginationInputObjectTypeResolver ??= $this->instanceManager->getInstance(TagPaginationInputObjectTypeResolver::class);
    }
    final public function setTaxonomySortInputObjectTypeResolver(TaxonomySortInputObjectTypeResolver $taxonomySortInputObjectTypeResolver): void
    {
        $this->taxonomySortInputObjectTypeResolver = $taxonomySortInputObjectTypeResolver;
    }
    final protected function getTaxonomySortInputObjectTypeResolver(): TaxonomySortInputObjectTypeResolver
    {
        /** @var TaxonomySortInputObjectTypeResolver */
        return $this->taxonomySortInputObjectTypeResolver ??= $this->instanceManager->getInstance(TaxonomySortInputObjectTypeResolver::class);
    }
    final public function setRootTagsFilterInputObjectTypeResolver(RootTagsFilterInputObjectTypeResolver $rootTagsFilterInputObjectTypeResolver): void
    {
        $this->rootTagsFilterInputObjectTypeResolver = $rootTagsFilterInputObjectTypeResolver;
    }
    final protected function getRootTagsFilterInputObjectTypeResolver(): RootTagsFilterInputObjectTypeResolver
    {
        /** @var RootTagsFilterInputObjectTypeResolver */
        return $this->rootTagsFilterInputObjectTypeResolver ??= $this->instanceManager->getInstance(RootTagsFilterInputObjectTypeResolver::class);
    }

    /**
     * @return array<class-string<ObjectTypeResolverInterface>>
     */
    public function getObjectTypeResolverClassesToAttachTo(): array
    {
        return [
            RootObjectTypeResolver::class,
        ];
    }

    /**
     * @return string[]
     */
    public function getFieldNamesToResolve(): array
    {
        return [
            'tag',
            'tags',
            'tagCount',
            'tagNames',
        ];
    }

    public function getFieldTypeResolver(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): ConcreteTypeResolverInterface
    {
        return match ($fieldName) {
            'tag',
            'tags'
                => $this->getTagUnionTypeResolver(),
            'tagCount'
                => $this->getIntScalarTypeResolver(),
            'tagNames'
                => $this->getStringScalarTypeResolver(),
            default
                => parent::getFieldTypeResolver($objectTypeResolver, $fieldName),
        };
    }

    public function getFieldTypeModifiers(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): int
    {
        return match ($fieldName) {
            'tagCount'
                => SchemaTypeModifiers::NON_NULLABLE,
            'tags',
            'tagNames'
                => SchemaTypeModifiers::NON_NULLABLE | SchemaTypeModifiers::IS_ARRAY | SchemaTypeModifiers::IS_NON_NULLABLE_ITEMS_IN_ARRAY,
            default
                => parent::getFieldTypeModifiers($objectTypeResolver, $fieldName),
        };
    }

    public function getFieldDescription(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): ?string
    {
        return match ($fieldName) {
            'tag' => $this->__('Retrieve a single post tag', 'pop-post-tags'),
            'tags' => $this->__(' tags', 'pop-post-tags'),
            'tagCount' => $this->__('Number of post tags', 'pop-post-tags'),
            'tagNames' => $this->__('Names of the post tags', 'pop-post-tags'),
            default => parent::getFieldDescription($objectTypeResolver, $fieldName),
        };
    }

    /**
     * @return array<string,InputTypeResolverInterface>
     */
    public function getFieldArgNameTypeResolvers(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): array
    {
        $fieldArgNameTypeResolvers = parent::getFieldArgNameTypeResolvers($objectTypeResolver, $fieldName);
        $commonFieldArgNameTypeResolvers = [
            'taxonomy' => $this->getTagTaxonomyEnumTypeResolver(),
        ];
        return match ($fieldName) {
            'tag' => array_merge(
                $fieldArgNameTypeResolvers,
                $commonFieldArgNameTypeResolvers,
                [
                    'by' => $this->getTagByInputObjectTypeResolver(),
                ]
            ),
            'tags',
            'tagNames' => array_merge(
                $fieldArgNameTypeResolvers,
                $commonFieldArgNameTypeResolvers,
                [
                    'filter' => $this->getRootTagsFilterInputObjectTypeResolver(),
                    'pagination' => $this->getTagPaginationInputObjectTypeResolver(),
                    'sort' => $this->getTaxonomySortInputObjectTypeResolver(),
                ]
            ),
            'tagCount' => array_merge(
                $fieldArgNameTypeResolvers,
                $commonFieldArgNameTypeResolvers,
                [
                    'filter' => $this->getRootTagsFilterInputObjectTypeResolver(),
                ]
            ),
            default => $fieldArgNameTypeResolvers,
        };
    }

    public function getFieldArgTypeModifiers(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName, string $fieldArgName): int
    {
        if ($fieldArgName === 'taxonomy') {
            return SchemaTypeModifiers::MANDATORY;
        }
        return match ([$fieldName => $fieldArgName]) {
            ['tag' => 'by'] => SchemaTypeModifiers::MANDATORY,
            default => parent::getFieldArgTypeModifiers($objectTypeResolver, $fieldName, $fieldArgName),
        };
    }

    public function getFieldArgDescription(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName, string $fieldArgName): ?string
    {
        if ($fieldArgName === 'taxonomy') {
            return $this->__('Taxonomy of the tag', 'tags');
        }
        return match ([$fieldName => $fieldArgName]) {
            ['tag' => 'by'] => $this->__('Parameter by which to select the tag', 'tags'),
            default => parent::getFieldArgDescription($objectTypeResolver, $fieldName, $fieldArgName),
        };
    }

    public function resolveValue(
        ObjectTypeResolverInterface $objectTypeResolver,
        object $object,
        FieldDataAccessorInterface $fieldDataAccessor,
        ObjectTypeFieldResolutionFeedbackStore $objectTypeFieldResolutionFeedbackStore,
    ): mixed {
        $query = $this->convertFieldArgsToFilteringQueryArgs($objectTypeResolver, $fieldDataAccessor);
        /** @var string */
        $tagTaxonomy = $fieldDataAccessor->getValue('taxonomy');
        switch ($fieldDataAccessor->getFieldName()) {
            case 'tag':
                if ($tags = $this->getTaxonomyTagListTypeAPI()->getTaxonomyTags($tagTaxonomy, $query, [QueryOptions::RETURN_TYPE => ReturnTypes::IDS])) {
                    return $tags[0];
                }
                return null;
            case 'tags':
                return $this->getTaxonomyTagListTypeAPI()->getTaxonomyTags($tagTaxonomy, $query, [QueryOptions::RETURN_TYPE => ReturnTypes::IDS]);
            case 'tagNames':
                return $this->getTaxonomyTagListTypeAPI()->getTaxonomyTags($tagTaxonomy, $query, [QueryOptions::RETURN_TYPE => ReturnTypes::NAMES]);
            case 'tagCount':
                return $this->getTaxonomyTagListTypeAPI()->getTaxonomyTagCount($tagTaxonomy, $query);
        }

        return parent::resolveValue($objectTypeResolver, $object, $fieldDataAccessor, $objectTypeFieldResolutionFeedbackStore);
    }
}
