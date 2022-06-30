<?php

declare(strict_types=1);

namespace PoP\ComponentModel\Mutation;

interface InputObjectFieldArgumentMutationDataProviderInterface extends MutationDataProviderInterface
{
    public function getArgumentName(): string;
}
