<?php
use PoP\ComponentModel\TypeResolvers\Object\ObjectTypeResolverInterface;

trait CommunityFieldResolverTrait
{
    /**
     * @param array<string, mixed> $fieldArgs
     */
    public function resolveCanProcessResultItem(
        ObjectTypeResolverInterface $objectTypeResolver,
        object $resultItem,
        string $fieldName,
        array $fieldArgs = []
    ): bool {
        $user = $resultItem;
        if (!gdUreIsCommunity($objectTypeResolver->getID($user))) {
            return false;
        }
        return parent::resolveCanProcessResultItem($objectTypeResolver, $resultItem, $fieldName, $fieldArgs);
    }
}
