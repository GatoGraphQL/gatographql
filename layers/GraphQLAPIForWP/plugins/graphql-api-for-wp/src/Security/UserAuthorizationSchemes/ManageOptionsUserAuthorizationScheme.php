<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\Security\UserAuthorizationSchemes;

class ManageOptionsUserAuthorizationScheme extends AbstractUserAuthorizationScheme implements DefaultUserAuthorizationSchemeTagInterface
{
    /**
     * Only the admin has capability "manage_options"
     */
    public function getSchemaEditorAccessCapability(): string
    {
        return 'manage_options';
    }

    public function getDescription(): string
    {
        return \__('Admin user(s) only', 'graphql-api');
    }
}
