<?php

declare(strict_types=1);

namespace PoPSchema\Stances\TypeResolvers\ObjectType;

use PoP\ComponentModel\RelationalTypeDataLoaders\RelationalTypeDataLoaderInterface;
use PoP\ComponentModel\TypeResolvers\ObjectType\AbstractObjectTypeResolver;
use PoPSchema\Stances\Facades\StanceTypeAPIFacade;
use PoPSchema\Stances\RelationalTypeDataLoaders\ObjectType\StanceTypeDataLoader;
use Symfony\Contracts\Service\Attribute\Required;

class StanceObjectTypeResolver extends AbstractObjectTypeResolver
{
    private ?StanceTypeDataLoader $stanceTypeDataLoader = null;
    
    public function setStanceTypeDataLoader(StanceTypeDataLoader $stanceTypeDataLoader): void
    {
        $this->stanceTypeDataLoader = $stanceTypeDataLoader;
    }
    protected function getStanceTypeDataLoader(): StanceTypeDataLoader
    {
        return $this->stanceTypeDataLoader ??= $this->instanceManager->getInstance(StanceTypeDataLoader::class);
    }

    //#[Required]
    final public function autowireStanceObjectTypeResolver(
        StanceTypeDataLoader $stanceTypeDataLoader,
    ): void {
        $this->stanceTypeDataLoader = $stanceTypeDataLoader;
    }
    
    public function getTypeName(): string
    {
        return 'Stance';
    }

    public function getTypeDescription(): ?string
    {
        return $this->translationAPI->__('A stance by the user (from among “positive”, “neutral” or “negative”) and why', 'stances');
    }

    public function getID(object $object): string | int | null
    {
        $stanceTypeAPI = StanceTypeAPIFacade::getInstance();
        return $stanceTypeAPI->getID($object);
    }

    public function getRelationalTypeDataLoader(): RelationalTypeDataLoaderInterface
    {
        return $this->getStanceTypeDataLoader();
    }
}
