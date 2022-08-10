<?php

declare(strict_types=1);

namespace PoP\ComponentModel\QueryResolution;

use PoP\GraphQLParser\Exception\AbstractValueResolutionPromiseException;

class DirectiveDataAccessor implements DirectiveDataAccessorInterface
{
    use FieldOrDirectiveDataAccessorTrait;

    public function __construct(
        /** @var array<string,mixed> */
        protected array $unresolvedDirectiveArgs,
    ) {
    }

    /**
     * @return array<string,mixed>
     * @throws AbstractValueResolutionPromiseException
     */
    public function getDirectiveArgs(): array
    {
        return $this->getResolvedFieldOrDirectiveArgs();
    }

    /**
     * @return array<string,mixed>
     */
    protected function getUnresolvedFieldOrDirectiveArgs(): array
    {
        return $this->unresolvedDirectiveArgs;
    }
}
