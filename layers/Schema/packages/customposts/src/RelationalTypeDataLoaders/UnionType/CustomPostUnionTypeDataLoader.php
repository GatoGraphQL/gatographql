<?php

declare(strict_types=1);

namespace PoPSchema\CustomPosts\RelationalTypeDataLoaders\UnionType;

use PoP\ComponentModel\Instances\InstanceManagerInterface;
use PoP\ComponentModel\RelationalTypeDataLoaders\UnionType\AbstractUnionTypeDataLoader;
use PoP\ComponentModel\TypeResolvers\UnionType\UnionTypeResolverInterface;
use PoP\Hooks\HooksAPIInterface;
use PoP\LooseContracts\NameResolverInterface;
use PoPSchema\CustomPosts\TypeResolvers\UnionType\CustomPostUnionTypeResolver;

class CustomPostUnionTypeDataLoader extends AbstractUnionTypeDataLoader
{
    protected CustomPostUnionTypeResolver $customPostUnionTypeResolver;
    
    #[\Symfony\Contracts\Service\Attribute\Required]
    public function autowireCustomPostUnionTypeDataLoader(
        CustomPostUnionTypeResolver $customPostUnionTypeResolver,
    ) {
        $this->customPostUnionTypeResolver = $customPostUnionTypeResolver;
    }

    protected function getUnionTypeResolver(): UnionTypeResolverInterface
    {
        return $this->customPostUnionTypeResolver;
    }
}
