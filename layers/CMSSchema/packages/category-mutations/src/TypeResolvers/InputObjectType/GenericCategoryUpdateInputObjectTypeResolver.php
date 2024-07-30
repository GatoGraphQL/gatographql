<?php

declare(strict_types=1);

namespace PoPCMSSchema\CategoryMutations\TypeResolvers\InputObjectType;

class GenericCategoryUpdateInputObjectTypeResolver extends CategoryUpdateInputObjectTypeResolver implements UpdateGenericCategoryTermInputObjectTypeResolverInterface
{
    public function getTypeName(): string
    {
        return 'GenericCategoryUpdateInput';
    }
}