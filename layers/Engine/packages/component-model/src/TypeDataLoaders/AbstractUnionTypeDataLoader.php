<?php

declare(strict_types=1);

namespace PoP\ComponentModel\TypeDataLoaders;

abstract class AbstractUnionTypeDataLoader extends AbstractTypeDataLoader
{
    abstract protected function getUnionTypeResolverClass(): string;

    /**
     * Iterate through all unionTypes and delegate to each resolving the IDs each of them can resolve
     */
    public function getObjects(array $ids): array
    {
        $unionTypeResolverClass = $this->getUnionTypeResolverClass();
        $unionTypeResolver = $this->instanceManager->getInstance($unionTypeResolverClass);
        $resultItemIDTargetObjectTypeResolvers = $unionTypeResolver->getResultItemIDTargetTypeResolvers($ids);
        // Organize all IDs by same resolverClass
        $typeResolverClassResultItemIDs = [];
        foreach ($resultItemIDTargetObjectTypeResolvers as $resultItemID => $targetObjectTypeResolver) {
            $typeResolverClassResultItemIDs[get_class($targetObjectTypeResolver)][] = $resultItemID;
        }
        // Load all objects by each corresponding typeResolver
        $resultItems = [];
        foreach ($typeResolverClassResultItemIDs as $targetTypeResolverClass => $resultItemIDs) {
            $targetTypeResolver = $this->instanceManager->getInstance($targetTypeResolverClass);
            $targetTypeDataLoaderClass = $targetTypeResolver->getRelationalTypeDataLoaderClass();
            $targetTypeDataLoader = $this->instanceManager->getInstance($targetTypeDataLoaderClass);
            $resultItems = array_merge(
                $resultItems,
                $targetTypeDataLoader->getObjects($resultItemIDs)
            );
        }
        return $resultItems;
    }
}
