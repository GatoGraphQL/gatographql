<?php

declare(strict_types=1);

namespace PoPCMSSchema\CustomPostTagMutations\Hooks;

use PoPCMSSchema\CustomPostTagMutations\Constants\MutationInputProperties;
use PoPCMSSchema\CustomPostTagMutations\FeedbackItemProviders\MutationErrorFeedbackItemProvider;
use PoPCMSSchema\CustomPostTagMutations\MutationResolvers\SetTagsOnCustomPostMutationResolverTrait;
use PoPCMSSchema\CustomPostTagMutations\ObjectModels\TagDoesNotExistErrorPayload;
use PoPCMSSchema\CustomPostTagMutations\TypeAPIs\CustomPostTagTypeMutationAPIInterface;
use PoPCMSSchema\CustomPosts\TypeAPIs\CustomPostTypeAPIInterface;
use PoPCMSSchema\TaxonomyMutations\FeedbackItemProviders\MutationErrorFeedbackItemProvider as TaxonomyMutationErrorFeedbackItemProvider;
use PoPCMSSchema\TaxonomyMutations\MutationResolvers\SetTaxonomyTermsOnCustomPostMutationResolverTrait;
use PoPCMSSchema\TaxonomyMutations\ObjectModels\LoggedInUserHasNoAssigningTermsToTaxonomyCapabilityErrorPayload;
use PoPCMSSchema\TaxonomyMutations\ObjectModels\TaxonomyIsNotValidErrorPayload;
use PoPSchema\SchemaCommons\ObjectModels\ErrorPayloadInterface;
use PoP\ComponentModel\Feedback\FeedbackItemResolution;
use PoP\ComponentModel\Feedback\ObjectTypeFieldResolutionFeedbackInterface;
use PoP\ComponentModel\Feedback\ObjectTypeFieldResolutionFeedbackStore;
use PoP\ComponentModel\QueryResolution\FieldDataAccessorInterface;
use PoP\Root\App;
use PoP\Root\Hooks\AbstractHookSet;
use stdClass;

abstract class AbstractMutationResolverHookSet extends AbstractHookSet
{
    use SetTagsOnCustomPostMutationResolverTrait;
    use SetTaxonomyTermsOnCustomPostMutationResolverTrait;

    private ?CustomPostTypeAPIInterface $customPostTypeAPI = null;
    private ?CustomPostTagTypeMutationAPIInterface $customPostTagTypeMutationAPI = null;

    final public function setCustomPostTypeAPI(CustomPostTypeAPIInterface $customPostTypeAPI): void
    {
        $this->customPostTypeAPI = $customPostTypeAPI;
    }
    final protected function getCustomPostTypeAPI(): CustomPostTypeAPIInterface
    {
        if ($this->customPostTypeAPI === null) {
            /** @var CustomPostTypeAPIInterface */
            $customPostTypeAPI = $this->instanceManager->getInstance(CustomPostTypeAPIInterface::class);
            $this->customPostTypeAPI = $customPostTypeAPI;
        }
        return $this->customPostTypeAPI;
    }
    final public function setCustomPostTagTypeMutationAPI(CustomPostTagTypeMutationAPIInterface $customPostTagTypeMutationAPI): void
    {
        $this->customPostTagTypeMutationAPI = $customPostTagTypeMutationAPI;
    }
    final protected function getCustomPostTagTypeMutationAPI(): CustomPostTagTypeMutationAPIInterface
    {
        if ($this->customPostTagTypeMutationAPI === null) {
            /** @var CustomPostTagTypeMutationAPIInterface */
            $customPostTagTypeMutationAPI = $this->instanceManager->getInstance(CustomPostTagTypeMutationAPIInterface::class);
            $this->customPostTagTypeMutationAPI = $customPostTagTypeMutationAPI;
        }
        return $this->customPostTagTypeMutationAPI;
    }

    protected function init(): void
    {
        App::addAction(
            $this->getValidateCreateOrUpdateHookName(),
            $this->maybeValidateTags(...),
            10,
            2
        );
        App::addAction(
            $this->getExecuteCreateOrUpdateHookName(),
            $this->maybeSetTags(...),
            10,
            3
        );
        App::addFilter(
            $this->getErrorPayloadHookName(),
            $this->createErrorPayloadFromObjectTypeFieldResolutionFeedback(...),
            10,
            2
        );
    }

    abstract protected function getValidateCreateOrUpdateHookName(): string;
    abstract protected function getExecuteCreateOrUpdateHookName(): string;
    abstract protected function getErrorPayloadHookName(): string;

    public function maybeValidateTags(
        FieldDataAccessorInterface $fieldDataAccessor,
        ObjectTypeFieldResolutionFeedbackStore $objectTypeFieldResolutionFeedbackStore,
    ): void {
        if (!$this->canExecuteMutation($fieldDataAccessor)) {
            return;
        }
    }

    protected function canExecuteMutation(
        FieldDataAccessorInterface $fieldDataAccessor,
    ): bool {
        if (!$fieldDataAccessor->hasValue(MutationInputProperties::TAGS_BY)) {
            return false;
        }
        /** @var stdClass */
        $tagsBy = $fieldDataAccessor->getValue(MutationInputProperties::TAGS_BY);
        if (((array) $tagsBy) === []) {
            return false;
        }

        return true;
    }

    public function maybeSetTags(
        int|string $customPostID,
        FieldDataAccessorInterface $fieldDataAccessor,
        ObjectTypeFieldResolutionFeedbackStore $objectTypeFieldResolutionFeedbackStore,
    ): void {
        if (!$this->canExecuteMutation($fieldDataAccessor)) {
            return;
        }

        /**
         * Validate the taxonomy is valid
         */
        $taxonomyName = $this->getTagTaxonomyName($customPostID, $fieldDataAccessor, $objectTypeFieldResolutionFeedbackStore);
        if ($taxonomyName === null) {
            return;
        }
        
        /**
         * Validate the tags are valid for that taxonomy
         *
         * @var stdClass
         */
        $tagsBy = $fieldDataAccessor->getValue(MutationInputProperties::TAGS_BY);
        if (isset($tagsBy->{MutationInputProperties::IDS})) {
            $customPostTagIDs = $tagsBy->{MutationInputProperties::IDS};
            $this->validateTagsExist(
                $taxonomyName,
                $customPostTagIDs,
                $fieldDataAccessor,
                $objectTypeFieldResolutionFeedbackStore,
            );
        }

        $tagsBy = $fieldDataAccessor->getValue(MutationInputProperties::TAGS_BY);
        $customPostTagSlugOrIDs = isset($tagsBy->{MutationInputProperties::IDS})
            ? $tagsBy->{MutationInputProperties::IDS}
            : $tagsBy->{MutationInputProperties::SLUGS};
        $this->getCustomPostTagTypeMutationAPI()->setTags(
            $taxonomyName,
            $customPostID,
            $customPostTagSlugOrIDs,
            false
        );
    }

    public function createErrorPayloadFromObjectTypeFieldResolutionFeedback(
        ErrorPayloadInterface $errorPayload,
        ObjectTypeFieldResolutionFeedbackInterface $objectTypeFieldResolutionFeedback,
    ): ErrorPayloadInterface {
        $feedbackItemResolution = $objectTypeFieldResolutionFeedback->getFeedbackItemResolution();
        return match (
            [
            $feedbackItemResolution->getFeedbackProviderServiceClass(),
            $feedbackItemResolution->getCode()
            ]
        ) {
            [
                MutationErrorFeedbackItemProvider::class,
                MutationErrorFeedbackItemProvider::E2,
            ] => new TagDoesNotExistErrorPayload(
                $feedbackItemResolution->getMessage(),
            ),
            [
                TaxonomyMutationErrorFeedbackItemProvider::class,
                TaxonomyMutationErrorFeedbackItemProvider::E10,
            ] => new LoggedInUserHasNoAssigningTermsToTaxonomyCapabilityErrorPayload(
                $feedbackItemResolution->getMessage(),
            ),
            [
                TaxonomyMutationErrorFeedbackItemProvider::class,
                TaxonomyMutationErrorFeedbackItemProvider::E11,
            ] => new TaxonomyIsNotValidErrorPayload(
                $feedbackItemResolution->getMessage(),
            ),
            [
                MutationErrorFeedbackItemProvider::class,
                MutationErrorFeedbackItemProvider::E3,
            ] => new TaxonomyIsNotValidErrorPayload(
                $feedbackItemResolution->getMessage(),
            ),
            [
                MutationErrorFeedbackItemProvider::class,
                MutationErrorFeedbackItemProvider::E4,
            ] => new TaxonomyIsNotValidErrorPayload(
                $feedbackItemResolution->getMessage(),
            ),
            [
                MutationErrorFeedbackItemProvider::class,
                MutationErrorFeedbackItemProvider::E5,
            ] => new TaxonomyIsNotValidErrorPayload(
                $feedbackItemResolution->getMessage(),
            ),
            default => $errorPayload,
        };
    }

    /**
     * Retrieve the taxonomy from the queried object's CPT,
     * which works as long as it has only 1 tag taxonomy registered.
     */
    protected function getTagTaxonomyName(
        int|string $customPostID,
        FieldDataAccessorInterface $fieldDataAccessor,
        ObjectTypeFieldResolutionFeedbackStore $objectTypeFieldResolutionFeedbackStore,
    ): ?string {
        return $this->getTaxonomyName(
            false,
            $customPostID,
            $fieldDataAccessor,
            $objectTypeFieldResolutionFeedbackStore,
        );
    }

    protected function getNoTaxonomiesRegisteredInCustomPostTypeFeedbackItemResolution(string $customPostType): FeedbackItemResolution
    {
        return new FeedbackItemResolution(
            MutationErrorFeedbackItemProvider::class,
            MutationErrorFeedbackItemProvider::E3,
            [
                $customPostType,
            ]
        );
    }

    /**
     * @param string[] $taxonomyNames
     */
    protected function getMultipleTaxonomiesRegisteredInCustomPostTypeFeedbackItemResolution(
        string $customPostType,
        array $taxonomyNames
    ): FeedbackItemResolution {
        return new FeedbackItemResolution(
            MutationErrorFeedbackItemProvider::class,
            MutationErrorFeedbackItemProvider::E4,
            [
                $customPostType,
                implode($this->__('\', \''), $taxonomyNames)
            ]
        );
    }
}
