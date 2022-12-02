<?php

declare(strict_types=1);

namespace PoPCMSSchema\CustomPostCategoryMutations\Hooks;

use PoPCMSSchema\CustomPostCategoryMutations\MutationResolvers\MutationInputProperties;
use PoPCMSSchema\CustomPostCategoryMutations\MutationResolvers\SetCategoriesOnCustomPostMutationResolverTrait;
use PoPCMSSchema\CustomPostCategoryMutations\TypeAPIs\CustomPostCategoryTypeMutationAPIInterface;
use PoPCMSSchema\CustomPostMutations\MutationResolvers\AbstractCreateUpdateCustomPostMutationResolver;
use PoPCMSSchema\CustomPostMutations\MutationResolvers\MutationInputProperties as CustomPostMutationsMutationInputProperties;
use PoPCMSSchema\CustomPosts\TypeAPIs\CustomPostTypeAPIInterface;
use PoP\ComponentModel\Feedback\ObjectTypeFieldResolutionFeedbackStore;
use PoP\ComponentModel\QueryResolution\FieldDataAccessorInterface;
use PoP\Root\App;
use PoP\Root\Hooks\AbstractHookSet;

abstract class AbstractMutationResolverHookSet extends AbstractHookSet
{
    use SetCategoriesOnCustomPostMutationResolverTrait;
 
    private ?CustomPostTypeAPIInterface $customPostTypeAPI = null;

    final public function setCustomPostTypeAPI(CustomPostTypeAPIInterface $customPostTypeAPI): void
    {
        $this->customPostTypeAPI = $customPostTypeAPI;
    }
    final protected function getCustomPostTypeAPI(): CustomPostTypeAPIInterface
    {
        /** @var CustomPostTypeAPIInterface */
        return $this->customPostTypeAPI ??= $this->instanceManager->getInstance(CustomPostTypeAPIInterface::class);
    }

    protected function init(): void
    {
        App::addAction(
            AbstractCreateUpdateCustomPostMutationResolver::HOOK_VALIDATE_CREATE_OR_UPDATE,
            $this->maybeValidateCategories(...),
            10,
            2
        );
        App::addAction(
            AbstractCreateUpdateCustomPostMutationResolver::HOOK_EXECUTE_CREATE_OR_UPDATE,
            $this->maybeSetCategories(...),
            10,
            2
        );
    }

    public function maybeValidateCategories(
        FieldDataAccessorInterface $fieldDataAccessor,
        ObjectTypeFieldResolutionFeedbackStore $objectTypeFieldResolutionFeedbackStore,
    ): void {
        if (!$this->canExecuteMutation($fieldDataAccessor)) {
            return;
        }
        $customPostCategoryIDs = $fieldDataAccessor->getValue(MutationInputProperties::CATEGORY_IDS);
        $this->validateCategoriesExist(
            $customPostCategoryIDs,
            $fieldDataAccessor,
            $objectTypeFieldResolutionFeedbackStore,
        );
    }

    protected function canExecuteMutation(
        FieldDataAccessorInterface $fieldDataAccessor,
    ): bool {
        if (!$fieldDataAccessor->hasValue(MutationInputProperties::CATEGORY_IDS)) {
            return false;
        }
        // Only for that specific CPT
        $customPostID = $fieldDataAccessor->getValue(CustomPostMutationsMutationInputProperties::ID);
        if ($this->getCustomPostTypeAPI()->getCustomPostType($customPostID) !== $this->getCustomPostType()) {
            return false;
        }
        return true;
    }

    public function maybeSetCategories(int|string $customPostID, FieldDataAccessorInterface $fieldDataAccessor): void
    {
        if (!$this->canExecuteMutation($fieldDataAccessor)) {
            return;
        }
        $customPostCategoryIDs = $fieldDataAccessor->getValue(MutationInputProperties::CATEGORY_IDS);
        $customPostCategoryTypeMutationAPI = $this->getCustomPostCategoryTypeMutationAPI();
        $customPostCategoryTypeMutationAPI->setCategories($customPostID, $customPostCategoryIDs, false);
    }

    abstract protected function getCustomPostType(): string;
    abstract protected function getCustomPostCategoryTypeMutationAPI(): CustomPostCategoryTypeMutationAPIInterface;
}
