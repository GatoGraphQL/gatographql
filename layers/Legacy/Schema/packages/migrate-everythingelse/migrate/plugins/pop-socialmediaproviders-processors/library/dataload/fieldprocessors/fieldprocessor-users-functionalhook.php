<?php
use PoPSchema\Users\TypeResolvers\Object\UserTypeResolver;

class PoP_SocialMediaProviders_DataLoad_FunctionalFieldResolver_UserSocialMediaItems extends PoP_SocialMediaProviders_DataLoad_FieldResolver_FunctionalSocialMediaItems
{
    public function getObjectTypeResolverClassesToAttachTo(): array
    {
        return [
            UserTypeResolver::class,
        ];
    }

    protected function getTitleField()
    {
        return 'displayName';
    }
}

// Static Initialization: Attach
(new PoP_SocialMediaProviders_DataLoad_FunctionalFieldResolver_UserSocialMediaItems())->attach(\PoP\ComponentModel\AttachableExtensions\AttachableExtensionGroups::FIELDRESOLVERS);
