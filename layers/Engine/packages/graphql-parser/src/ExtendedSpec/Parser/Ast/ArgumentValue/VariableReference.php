<?php

declare(strict_types=1);

namespace PoP\GraphQLParser\ExtendedSpec\Parser\Ast\ArgumentValue;

use PoP\ComponentModel\Feedback\FeedbackItemResolution;
use PoP\GraphQLParser\Exception\Parser\InvalidRequestException;
use PoP\GraphQLParser\FeedbackItemProviders\FeedbackItemProvider;
use PoP\GraphQLParser\FeedbackItemProviders\GraphQLSpecErrorFeedbackItemProvider;
use PoP\GraphQLParser\Spec\Execution\Context;
use PoP\GraphQLParser\Spec\Parser\Ast\ArgumentValue\InputList;
use PoP\GraphQLParser\Spec\Parser\Ast\ArgumentValue\InputObject;
use PoP\GraphQLParser\Spec\Parser\Ast\ArgumentValue\Literal;
use PoP\GraphQLParser\Spec\Parser\Ast\ArgumentValue\VariableReference as UpstreamVariableReference;
use stdClass;

class VariableReference extends UpstreamVariableReference
{
    private ?Context $context = null;

    public function setContext(?Context $context): void
    {
        $this->context = $context;
    }

    final public function isDynamicVariable(): bool
    {
        return \str_starts_with($this->name, '_');
    }

    /**
     * Override to handle dynamic variables too
     *
     * @throws InvalidRequestException
     */
    public function getValue(): mixed
    {
        if ($this->variable === null && $this->isDynamicVariable()) {
            return $this->getDynamicVariableValue();
        }

        return parent::getValue();
    }

    public function getDynamicVariableValue(): mixed
    {
        if ($this->context === null) {
            throw new InvalidRequestException(
                new FeedbackItemResolution(
                    FeedbackItemProvider::class,
                    FeedbackItemProvider::E2,
                    [
                        $this->name,
                    ]
                ),
                $this->getLocation()
            );
        }
        if (!$this->context->hasVariableValue($this->name)) {
            throw new InvalidRequestException(
                new FeedbackItemResolution(
                    GraphQLSpecErrorFeedbackItemProvider::class,
                    GraphQLSpecErrorFeedbackItemProvider::E_5_8_3,
                    [
                        $this->name,
                    ]
                ),
                $this->getLocation()
            );
        }
        $variableValue = $this->context->getVariableValue($this->name);
        if (is_array($variableValue)) {
            return new InputList($variableValue, $this->getLocation());
        }
        if ($variableValue instanceof stdClass) {
            return new InputObject($variableValue, $this->getLocation());
        }
        return new Literal($variableValue, $this->getLocation());
    }
}
