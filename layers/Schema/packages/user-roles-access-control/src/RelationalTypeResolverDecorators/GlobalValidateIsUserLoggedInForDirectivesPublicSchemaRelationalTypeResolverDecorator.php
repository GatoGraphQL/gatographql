<?php

declare(strict_types=1);

namespace PoPSchema\UserRolesAccessControl\RelationalTypeResolverDecorators;

use PoP\ComponentModel\DirectiveResolvers\DirectiveResolverInterface;
use PoP\ComponentModel\TypeResolvers\AbstractRelationalTypeResolver;
use PoPSchema\UserRolesAccessControl\DirectiveResolvers\ValidateDoesLoggedInUserHaveAnyCapabilityForDirectivesDirectiveResolver;
use PoPSchema\UserRolesAccessControl\DirectiveResolvers\ValidateDoesLoggedInUserHaveAnyRoleForDirectivesDirectiveResolver;
use PoPSchema\UserStateAccessControl\RelationalTypeResolverDecorators\AbstractValidateIsUserLoggedInForDirectivesPublicSchemaRelationalTypeResolverDecorator;
use Symfony\Contracts\Service\Attribute\Required;

class GlobalValidateIsUserLoggedInForDirectivesPublicSchemaRelationalTypeResolverDecorator extends AbstractValidateIsUserLoggedInForDirectivesPublicSchemaRelationalTypeResolverDecorator
{
    private ?ValidateDoesLoggedInUserHaveAnyRoleForDirectivesDirectiveResolver $validateDoesLoggedInUserHaveAnyRoleForDirectivesDirectiveResolver = null;
    private ?ValidateDoesLoggedInUserHaveAnyCapabilityForDirectivesDirectiveResolver $validateDoesLoggedInUserHaveAnyCapabilityForDirectivesDirectiveResolver = null;

    public function setValidateDoesLoggedInUserHaveAnyRoleForDirectivesDirectiveResolver(ValidateDoesLoggedInUserHaveAnyRoleForDirectivesDirectiveResolver $validateDoesLoggedInUserHaveAnyRoleForDirectivesDirectiveResolver): void
    {
        $this->validateDoesLoggedInUserHaveAnyRoleForDirectivesDirectiveResolver = $validateDoesLoggedInUserHaveAnyRoleForDirectivesDirectiveResolver;
    }
    protected function getValidateDoesLoggedInUserHaveAnyRoleForDirectivesDirectiveResolver(): ValidateDoesLoggedInUserHaveAnyRoleForDirectivesDirectiveResolver
    {
        return $this->validateDoesLoggedInUserHaveAnyRoleForDirectivesDirectiveResolver ??= $this->getInstanceManager()->getInstance(ValidateDoesLoggedInUserHaveAnyRoleForDirectivesDirectiveResolver::class);
    }
    public function setValidateDoesLoggedInUserHaveAnyCapabilityForDirectivesDirectiveResolver(ValidateDoesLoggedInUserHaveAnyCapabilityForDirectivesDirectiveResolver $validateDoesLoggedInUserHaveAnyCapabilityForDirectivesDirectiveResolver): void
    {
        $this->validateDoesLoggedInUserHaveAnyCapabilityForDirectivesDirectiveResolver = $validateDoesLoggedInUserHaveAnyCapabilityForDirectivesDirectiveResolver;
    }
    protected function getValidateDoesLoggedInUserHaveAnyCapabilityForDirectivesDirectiveResolver(): ValidateDoesLoggedInUserHaveAnyCapabilityForDirectivesDirectiveResolver
    {
        return $this->validateDoesLoggedInUserHaveAnyCapabilityForDirectivesDirectiveResolver ??= $this->getInstanceManager()->getInstance(ValidateDoesLoggedInUserHaveAnyCapabilityForDirectivesDirectiveResolver::class);
    }

    public function getRelationalTypeResolverClassesToAttachTo(): array
    {
        return [
            AbstractRelationalTypeResolver::class,
        ];
    }

    /**
     * Provide the DirectiveResolvers that need the "validateIsUserLoggedIn" directive
     *
     * @return DirectiveResolverInterface[]
     */
    protected function getDirectiveResolvers(): array
    {
        return [
            $this->getValidateDoesLoggedInUserHaveAnyRoleForDirectivesDirectiveResolver(),
            $this->getValidateDoesLoggedInUserHaveAnyCapabilityForDirectivesDirectiveResolver(),
        ];
    }
}
