<?php

declare(strict_types=1);

namespace PoP\ComponentModel\GraphQLEngine\Model\ComponentModelSpec;

use PoP\GraphQLParser\Spec\Parser\Ast\LeafField;

class LeafComponentField extends AbstractComponentField
{
    /**
     * Retrieve a new instance with all the properties from the LeafField
     */
    public static function fromLeafField(
        LeafField $leafField,
    ): self {
        return new self(
            $leafField->getName(),
            $leafField->getAlias(),
            $leafField->getArguments(),
            $leafField->getDirectives(),
            $leafField->getLocation(),
        );
    }
}
