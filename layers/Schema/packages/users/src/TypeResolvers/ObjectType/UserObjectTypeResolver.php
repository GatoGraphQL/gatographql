<?php

declare(strict_types=1);

namespace PoPSchema\Users\TypeResolvers\ObjectType;

use PoP\ComponentModel\RelationalTypeDataLoaders\RelationalTypeDataLoaderInterface;
use PoP\ComponentModel\TypeResolvers\ObjectType\AbstractObjectTypeResolver;
use PoPSchema\Users\RelationalTypeDataLoaders\ObjectType\UserTypeDataLoader;
use PoPSchema\Users\TypeAPIs\UserTypeAPIInterface;
use Symfony\Contracts\Service\Attribute\Required;

class UserObjectTypeResolver extends AbstractObjectTypeResolver
{
    private ?UserTypeAPIInterface $userTypeAPI = null;
    private ?UserTypeDataLoader $userTypeDataLoader = null;

    public function setUserTypeAPI(UserTypeAPIInterface $userTypeAPI): void
    {
        $this->userTypeAPI = $userTypeAPI;
    }
    protected function getUserTypeAPI(): UserTypeAPIInterface
    {
        return $this->userTypeAPI ??= $this->getInstanceManager()->getInstance(UserTypeAPIInterface::class);
    }
    public function setUserTypeDataLoader(UserTypeDataLoader $userTypeDataLoader): void
    {
        $this->userTypeDataLoader = $userTypeDataLoader;
    }
    protected function getUserTypeDataLoader(): UserTypeDataLoader
    {
        return $this->userTypeDataLoader ??= $this->getInstanceManager()->getInstance(UserTypeDataLoader::class);
    }

    public function getTypeName(): string
    {
        return 'User';
    }

    public function getTypeDescription(): ?string
    {
        return $this->getTranslationAPI()->__('Representation of a user', 'users');
    }

    public function getID(object $object): string | int | null
    {
        $user = $object;
        return $this->getUserTypeAPI()->getUserId($user);
    }

    public function getRelationalTypeDataLoader(): RelationalTypeDataLoaderInterface
    {
        return $this->getUserTypeDataLoader();
    }
}
