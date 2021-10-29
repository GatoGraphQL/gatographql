<?php

declare(strict_types=1);

namespace PoPSchema\GenericCustomPosts\TypeResolvers\ObjectType;

use PoP\ComponentModel\RelationalTypeDataLoaders\RelationalTypeDataLoaderInterface;
use PoPSchema\CustomPosts\TypeResolvers\ObjectType\AbstractCustomPostObjectTypeResolver;
use PoPSchema\GenericCustomPosts\RelationalTypeDataLoaders\ObjectType\GenericCustomPostTypeDataLoader;
use Symfony\Contracts\Service\Attribute\Required;

class GenericCustomPostObjectTypeResolver extends AbstractCustomPostObjectTypeResolver
{
    private ?GenericCustomPostTypeDataLoader $genericCustomPostTypeDataLoader = null;

    public function setGenericCustomPostTypeDataLoader(GenericCustomPostTypeDataLoader $genericCustomPostTypeDataLoader): void
    {
        $this->genericCustomPostTypeDataLoader = $genericCustomPostTypeDataLoader;
    }
    protected function getGenericCustomPostTypeDataLoader(): GenericCustomPostTypeDataLoader
    {
        return $this->genericCustomPostTypeDataLoader ??= $this->instanceManager->getInstance(GenericCustomPostTypeDataLoader::class);
    }

    public function getTypeName(): string
    {
        return 'GenericCustomPost';
    }

    public function getTypeDescription(): ?string
    {
        return $this->translationAPI->__('Any custom post, with or without its own type for the schema', 'customposts');
    }

    public function getRelationalTypeDataLoader(): RelationalTypeDataLoaderInterface
    {
        return $this->getGenericCustomPostTypeDataLoader();
    }
}
