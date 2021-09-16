<?php

declare(strict_types=1);

namespace PoP\Engine\TypeResolvers\ScalarType;

use PoP\ComponentModel\TypeResolvers\ScalarType\AbstractScalarTypeResolver;

/**
 * GraphQL Built-in Scalar
 * 
 * @see https://spec.graphql.org/draft/#sec-Scalars.Built-in-Scalars
 */
class IDScalarTypeResolver extends AbstractScalarTypeResolver
{
    public function getTypeName(): string
    {
        return 'ID';
    }

    public function coerceValue(mixed $inputValue): mixed
    {
        if ($error = $this->validateIsNotArrayOrObject($inputValue)) {
            return $error;
        }
        /**
         * Type ID in GraphQL spec: only String or Int allowed.
         * 
         * @see https://spec.graphql.org/draft/#sec-ID.Input-Coercion
         */
        if (is_float($inputValue) || is_bool($inputValue)) {
            return $this->getError(
                sprintf(
                    $this->translationAPI->__('Only strings or integers are allowed for type \'%s\'', 'component-model'),
                    $this->getMaybeNamespacedTypeName()
                )
            );
        }
        return $inputValue;
    }
}
