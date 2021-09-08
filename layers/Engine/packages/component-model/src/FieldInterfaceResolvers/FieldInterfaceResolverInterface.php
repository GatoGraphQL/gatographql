<?php

declare(strict_types=1);

namespace PoP\ComponentModel\FieldInterfaceResolvers;

use PoP\ComponentModel\AttachableExtensions\AttachableExtensionInterface;

interface FieldInterfaceResolverInterface extends AttachableExtensionInterface
{
    /**
     * The classes of the InterfaceTypeResolvers this FieldInterfaceResolver adds fields to.
     * The list can contain both concrete and abstract classes (in which case all classes
     * extending from them will be selected)
     * 
     * @return string[]
     */
    public function getInterfaceTypeResolverClassesToAttachTo(): array;
    /**
     * Get an array with the fieldNames that the fieldResolver must implement
     */
    public function getFieldNamesToImplement(): array;
    /**
     * An interface can itself implement other interfaces!
     */
    public function getImplementedFieldInterfaceResolverClasses(): array;
    /**
     * Each FieldInterfaceResolver provides a list of fieldNames to the Interface.
     * The Interface may also accept other fieldNames from other FieldInterfaceResolvers.
     * That's why this function is "partially" implemented: the Interface
     * may be completely implemented or not.
     * 
     * @return InterfaceTypeResolverInterface[]
     */
    public function getPartiallyImplementedInterfaceTypeResolvers(): array;
    /**
     * @return string[]
     */
    public function getPartiallyImplementedInterfaceTypeResolverClasses(): array;
}
