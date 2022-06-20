<?php

declare(strict_types=1);

namespace PoP\ComponentModel\DirectiveResolvers;

use PoP\ComponentModel\AttachableExtensions\AttachableExtensionInterface;
use PoP\ComponentModel\Engine\EngineIterationFieldSet;
use PoP\ComponentModel\Feedback\EngineIterationFeedbackStore;
use PoP\ComponentModel\Feedback\ObjectTypeFieldResolutionFeedbackStore;
use PoP\ComponentModel\TypeResolvers\InputTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\RelationalTypeResolverInterface;
use PoP\GraphQLParser\Spec\Parser\Ast\FieldInterface;
use PoP\Root\Feedback\FeedbackItemResolution;

interface DirectiveResolverInterface extends AttachableExtensionInterface, SchemaDirectiveResolverInterface
{
    /**
     * The classes of the ObjectTypeResolvers and/or InterfaceTypeResolvers
     * this DirectiveResolver adds directives to.
     * The list can contain both concrete and abstract classes (in which case all classes
     * extending from them will be selected)
     *
     * @return string[]
     */
    public function getRelationalTypeOrInterfaceTypeResolverClassesToAttachTo(): array;
    public function getDirectiveName(): string;
    /**
     * Invoked when creating the non-shared directive instance
     * to resolve a field in the pipeline
     */
    public function setDirective(string $directive): void;
    /**
     * Indicate to what fieldNames this directive can be applied.
     * Returning an empty array means all of them
     */
    public function getFieldNamesToApplyTo(): array;
    /**
     * Directives can be either of type "Schema" or "Query" and,
     * depending on one case or the other, might be exposed to the user.
     * By default, use the Query type
     */
    public function getDirectiveKind(): string;
    /**
     * Extract and validate the directive arguments
     *
     * @param array<string,FieldInterface[]> $fieldDirectiveFields
     */
    public function dissectAndValidateDirectiveForSchema(
        RelationalTypeResolverInterface $relationalTypeResolver,
        array &$fieldDirectiveFields,
        array &$variables,
        EngineIterationFeedbackStore $engineIterationFeedbackStore,
    ): array;

    /**
     * Enable the directiveResolver to validate the directive arguments in a custom way
     */
    public function validateDirectiveArgumentsForSchema(
        RelationalTypeResolverInterface $relationalTypeResolver,
        string $directiveName,
        array $directiveArgs,
        ObjectTypeFieldResolutionFeedbackStore $objectTypeFieldResolutionFeedbackStore,
    ): array;

    /**
     * Define where to place the directive in the directive execution pipeline
     *
     * 3 directives are mandatory, and executed in this order:
     *
     *   1. Validate: to validate that the schema, fieldNames, etc are supported, and filter them out if not
     *   2. ResolveAndMerge: to resolve the field and place the data into the DB object
     *   3. SerializeLeafOutputTypeValuesInDBItems: to serialize Scalar and Enum Type values
     * 
     * All other directives must indicate where to position themselves,
     * using these 3 directives as anchors.
     *
     * There are 6 positions:
     *
     *   1. At the very beginning
     *   2. Before Validate directive
     *   3. Between the Validate and Resolve directives
     *   4. Between the Resolve and Serialize directives
     *   5. After the Serialize directive
     *   6. At the very end
     *
     * In the "serialize" step, the directive takes the objects
     * stored in $resolvedIDFieldValues, such as a DateTime object,
     * and converts them to string for printing in the response.
     */
    public function getPipelinePosition(): string;

    /**
     * This is the equivalent to `__invoke` in League\Pipeline\StageInterface
     *
     * @param mixed[] $payload
     * @return mixed[]
     */
    public function resolveDirectivePipelinePayload(array $payload): array;
    /**
     * Indicate if the directiveResolver can process the directive with the given name and args
     */
    public function resolveCanProcess(
        RelationalTypeResolverInterface $relationalTypeResolver,
        string $directiveName,
        array $directiveArgs,
        FieldInterface $field,
        array &$variables
    ): bool;
    /**
     * Indicates if the directive can be added several times to the pipeline, or only once
     */
    public function isRepeatable(): bool;
    /**
     * Indicate if the directive needs to be passed $idFieldSet filled with data to be able to execute
     */
    public function needsSomeIDFieldToExecute(): bool;
    /**
     * Execute the directive
     *
     * @param array<string|int,EngineIterationFieldSet> $idFieldSet
     * @param array<array<string|int,EngineIterationFieldSet>> $succeedingPipelineIDFieldSet
     */
    public function resolveDirective(
        RelationalTypeResolverInterface $relationalTypeResolver,
        array $idFieldSet,
        array $succeedingPipelineDirectiveResolverInstances,
        array $objectIDItems,
        array $unionDBKeyIDs,
        array $previousResolvedIDFieldValues,
        array &$succeedingPipelineIDFieldSet,
        array &$resolvedIDFieldValues,
        array &$variables,
        array &$messages,
        EngineIterationFeedbackStore $engineIterationFeedbackStore,
    ): void;
    /**
     * A directive can decide to not be added to the schema, eg: when it is repeated/implemented several times
     */
    public function skipExposingDirectiveInSchema(RelationalTypeResolverInterface $relationalTypeResolver): bool;
    public function skipExposingDirectiveArgInSchema(RelationalTypeResolverInterface $relationalTypeResolver, string $directiveArgName): bool;
    public function getDirectiveSchemaDefinition(RelationalTypeResolverInterface $relationalTypeResolver): array;
    /**
     * Define if to use the version to decide if to process the directive or not
     */
    public function decideCanProcessBasedOnVersionConstraint(RelationalTypeResolverInterface $relationalTypeResolver): bool;
    /**
     * The version of the directive, using semantic versioning
     */
    public function getDirectiveVersion(RelationalTypeResolverInterface $relationalTypeResolver): ?string;
    public function hasDirectiveVersion(RelationalTypeResolverInterface $relationalTypeResolver): bool;
    public function getDirectiveVersionInputTypeResolver(RelationalTypeResolverInterface $relationalTypeResolver): ?InputTypeResolverInterface;

    /**
     * @return FeedbackItemResolution[] Errors
     */
    public function resolveDirectiveValidationErrors(
        RelationalTypeResolverInterface $relationalTypeResolver,
        string $directiveName,
        array $directiveArgs
    ): array;
    public function resolveDirectiveWarning(RelationalTypeResolverInterface $relationalTypeResolver): ?FeedbackItemResolution;
    public function getDirectiveDeprecationMessage(RelationalTypeResolverInterface $relationalTypeResolver): ?string;
}
