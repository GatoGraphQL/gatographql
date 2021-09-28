<?php

declare(strict_types=1);

namespace PoPSchema\UserRolesAccessControl\RelationalTypeResolverDecorators;

use PoP\ComponentModel\DirectiveResolvers\DirectiveResolverInterface;
use PoP\ComponentModel\Instances\InstanceManagerInterface;
use PoP\ComponentModel\Schema\FieldQueryInterpreterInterface;
use PoP\ComponentModel\TypeResolvers\AbstractRelationalTypeResolver;
use PoPSchema\UserRolesAccessControl\DirectiveResolvers\ValidateDoesLoggedInUserHaveAnyCapabilityForDirectivesDirectiveResolver;
use PoPSchema\UserRolesAccessControl\DirectiveResolvers\ValidateDoesLoggedInUserHaveAnyRoleForDirectivesDirectiveResolver;
use PoPSchema\UserStateAccessControl\DirectiveResolvers\ValidateIsUserLoggedInForDirectivesDirectiveResolver;
use PoPSchema\UserStateAccessControl\RelationalTypeResolverDecorators\AbstractValidateIsUserLoggedInForDirectivesPublicSchemaRelationalTypeResolverDecorator;

class GlobalValidateIsUserLoggedInForDirectivesPublicSchemaRelationalTypeResolverDecorator extends AbstractValidateIsUserLoggedInForDirectivesPublicSchemaRelationalTypeResolverDecorator
{
    protected ValidateDoesLoggedInUserHaveAnyRoleForDirectivesDirectiveResolver $validateDoesLoggedInUserHaveAnyRoleForDirectivesDirectiveResolver;
    protected ValidateDoesLoggedInUserHaveAnyCapabilityForDirectivesDirectiveResolver $validateDoesLoggedInUserHaveAnyCapabilityForDirectivesDirectiveResolver;
    
    #[\Symfony\Contracts\Service\Attribute\Required]
    public function autowireGlobalValidateIsUserLoggedInForDirectivesPublicSchemaRelationalTypeResolverDecorator(
        ValidateDoesLoggedInUserHaveAnyRoleForDirectivesDirectiveResolver $validateDoesLoggedInUserHaveAnyRoleForDirectivesDirectiveResolver,
        ValidateDoesLoggedInUserHaveAnyCapabilityForDirectivesDirectiveResolver $validateDoesLoggedInUserHaveAnyCapabilityForDirectivesDirectiveResolver,
    ) {
        $this->validateDoesLoggedInUserHaveAnyRoleForDirectivesDirectiveResolver = $validateDoesLoggedInUserHaveAnyRoleForDirectivesDirectiveResolver;
        $this->validateDoesLoggedInUserHaveAnyCapabilityForDirectivesDirectiveResolver = $validateDoesLoggedInUserHaveAnyCapabilityForDirectivesDirectiveResolver;
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
            $this->validateDoesLoggedInUserHaveAnyRoleForDirectivesDirectiveResolver,
            $this->validateDoesLoggedInUserHaveAnyCapabilityForDirectivesDirectiveResolver,
        ];
    }
}
