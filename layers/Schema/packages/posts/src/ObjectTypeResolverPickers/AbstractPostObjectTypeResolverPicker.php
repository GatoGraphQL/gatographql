<?php

declare(strict_types=1);

namespace PoPSchema\Posts\ObjectTypeResolverPickers;

use PoP\ComponentModel\ObjectTypeResolverPickers\AbstractObjectTypeResolverPicker;
use PoP\ComponentModel\TypeResolvers\ObjectType\ObjectTypeResolverInterface;
use PoPSchema\Posts\TypeAPIs\PostTypeAPIInterface;
use PoPSchema\Posts\TypeResolvers\ObjectType\PostObjectTypeResolver;
use Symfony\Contracts\Service\Attribute\Required;

abstract class AbstractPostObjectTypeResolverPicker extends AbstractObjectTypeResolverPicker
{
    private ?PostObjectTypeResolver $postObjectTypeResolver = null;
    private ?PostTypeAPIInterface $postTypeAPI = null;

    public function setPostObjectTypeResolver(PostObjectTypeResolver $postObjectTypeResolver): void
    {
        $this->postObjectTypeResolver = $postObjectTypeResolver;
    }
    protected function getPostObjectTypeResolver(): PostObjectTypeResolver
    {
        return $this->postObjectTypeResolver ??= $this->getInstanceManager()->getInstance(PostObjectTypeResolver::class);
    }
    public function setPostTypeAPI(PostTypeAPIInterface $postTypeAPI): void
    {
        $this->postTypeAPI = $postTypeAPI;
    }
    protected function getPostTypeAPI(): PostTypeAPIInterface
    {
        return $this->postTypeAPI ??= $this->getInstanceManager()->getInstance(PostTypeAPIInterface::class);
    }

    public function getObjectTypeResolver(): ObjectTypeResolverInterface
    {
        return $this->getPostObjectTypeResolver();
    }

    public function isInstanceOfType(object $object): bool
    {
        return $this->getPostTypeAPI()->isInstanceOfPostType($object);
    }

    public function isIDOfType(string | int $objectID): bool
    {
        return $this->getPostTypeAPI()->postExists($objectID);
    }
}
