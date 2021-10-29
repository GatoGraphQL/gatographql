<?php

declare(strict_types=1);

namespace PoPSchema\UserStateAccessControl\RelationalTypeResolverDecorators;

use PoP\ComponentModel\DirectiveResolvers\DirectiveResolverInterface;
use PoPSchema\UserStateAccessControl\ConfigurationEntries\UserStates;
use PoPSchema\UserStateAccessControl\DirectiveResolvers\ValidateIsUserLoggedInForDirectivesDirectiveResolver;
use Symfony\Contracts\Service\Attribute\Required;

trait ValidateUserLoggedInForDirectivesRelationalTypeResolverDecoratorTrait
{
    private ?ValidateIsUserLoggedInForDirectivesDirectiveResolver $validateIsUserLoggedInForDirectivesDirectiveResolver = null;

    public function setValidateIsUserLoggedInForDirectivesDirectiveResolver(ValidateIsUserLoggedInForDirectivesDirectiveResolver $validateIsUserLoggedInForDirectivesDirectiveResolver): void
    {
        $this->validateIsUserLoggedInForDirectivesDirectiveResolver = $validateIsUserLoggedInForDirectivesDirectiveResolver;
    }
    protected function getValidateIsUserLoggedInForDirectivesDirectiveResolver(): ValidateIsUserLoggedInForDirectivesDirectiveResolver
    {
        return $this->validateIsUserLoggedInForDirectivesDirectiveResolver ??= $this->getInstanceManager()->getInstance(ValidateIsUserLoggedInForDirectivesDirectiveResolver::class);
    }

    protected function getRequiredEntryValue(): ?string
    {
        return UserStates::IN;
    }
    protected function getValidateUserStateDirectiveResolver(): DirectiveResolverInterface
    {
        return $this->getValidateIsUserLoggedInForDirectivesDirectiveResolver();
    }
}
