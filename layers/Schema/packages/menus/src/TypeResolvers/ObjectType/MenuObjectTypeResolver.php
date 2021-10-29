<?php

declare(strict_types=1);

namespace PoPSchema\Menus\TypeResolvers\ObjectType;

use PoP\ComponentModel\RelationalTypeDataLoaders\RelationalTypeDataLoaderInterface;
use PoP\ComponentModel\TypeResolvers\ObjectType\AbstractObjectTypeResolver;
use PoPSchema\Menus\RelationalTypeDataLoaders\ObjectType\MenuTypeDataLoader;
use PoPSchema\Menus\TypeAPIs\MenuTypeAPIInterface;
use Symfony\Contracts\Service\Attribute\Required;

class MenuObjectTypeResolver extends AbstractObjectTypeResolver
{
    private ?MenuTypeDataLoader $menuTypeDataLoader = null;
    private ?MenuTypeAPIInterface $menuTypeAPI = null;

    public function setMenuTypeDataLoader(MenuTypeDataLoader $menuTypeDataLoader): void
    {
        $this->menuTypeDataLoader = $menuTypeDataLoader;
    }
    protected function getMenuTypeDataLoader(): MenuTypeDataLoader
    {
        return $this->menuTypeDataLoader ??= $this->getInstanceManager()->getInstance(MenuTypeDataLoader::class);
    }
    public function setMenuTypeAPI(MenuTypeAPIInterface $menuTypeAPI): void
    {
        $this->menuTypeAPI = $menuTypeAPI;
    }
    protected function getMenuTypeAPI(): MenuTypeAPIInterface
    {
        return $this->menuTypeAPI ??= $this->getInstanceManager()->getInstance(MenuTypeAPIInterface::class);
    }

    public function getTypeName(): string
    {
        return 'Menu';
    }

    public function getTypeDescription(): ?string
    {
        return $this->getTranslationAPI()->__('Representation of a navigation menu', 'menus');
    }

    public function getID(object $object): string | int | null
    {
        $menu = $object;
        return $this->getMenuTypeAPI()->getMenuID($menu);
    }

    public function getRelationalTypeDataLoader(): RelationalTypeDataLoaderInterface
    {
        return $this->getMenuTypeDataLoader();
    }
}
