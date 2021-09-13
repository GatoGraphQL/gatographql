<?php
use PoP\ComponentModel\TypeResolvers\ObjectType\ObjectTypeResolverInterface;

trait OrganizationObjectTypeFieldResolverTrait
{
    /**
     * @param array<string, mixed> $fieldArgs
     */
    public function resolveCanProcessResultItem(
        ObjectTypeResolverInterface $objectTypeResolver,
        object $object,
        string $fieldName,
        array $fieldArgs = []
    ): bool {
        $user = $object;
        if (!gdUreIsOrganization($objectTypeResolver->getID($user))) {
            return false;
        }
        return parent::resolveCanProcessResultItem($objectTypeResolver, $object, $fieldName, $fieldArgs);
    }
}
