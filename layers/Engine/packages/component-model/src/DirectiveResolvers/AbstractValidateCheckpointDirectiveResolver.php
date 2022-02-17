<?php

declare(strict_types=1);

namespace PoP\ComponentModel\DirectiveResolvers;

use PoP\ComponentModel\Engine\EngineInterface;
use PoP\ComponentModel\TypeResolvers\RelationalTypeResolverInterface;

abstract class AbstractValidateCheckpointDirectiveResolver extends AbstractValidateConditionDirectiveResolver
{
    private ?EngineInterface $engine = null;

    final public function setEngine(EngineInterface $engine): void
    {
        $this->engine = $engine;
    }
    final protected function getEngine(): EngineInterface
    {
        return $this->engine ??= $this->instanceManager->getInstance(EngineInterface::class);
    }

    /**
     * Validate checkpoints
     */
    protected function validateCondition(RelationalTypeResolverInterface $relationalTypeResolver): bool
    {
        $checkpointSet = $this->getValidationCheckpointSet($relationalTypeResolver);
        $checkpointError = $this->getEngine()->validateCheckpoints($checkpointSet);
        return $checkpointError !== null;
    }

    /**
     * Provide the checkpoint to validate
     */
    abstract protected function getValidationCheckpointSet(RelationalTypeResolverInterface $relationalTypeResolver): array;
}
