<?php

declare(strict_types=1);

namespace PoPCMSSchema\UserRolesAccessControl\DirectiveResolvers;

class ValidateDoesLoggedInUserHaveAnyRoleForDirectivesFieldDirectiveResolver extends ValidateDoesLoggedInUserHaveAnyRoleFieldDirectiveResolver
{
    public function getDirectiveName(): string
    {
        return 'validateDoesLoggedInUserHaveAnyRoleForDirectives';
    }

    protected function isValidatingDirective(): bool
    {
        return true;
    }
}
