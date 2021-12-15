<?php

declare(strict_types=1);

namespace PoP\GraphQLParser\Exception\Interfaces;

use PoP\GraphQLParser\Parser\Location;

interface LocationableExceptionInterface
{
    public function getLocation(): Location;
}
