<?php

declare(strict_types=1);

namespace PoP\ComponentModel\MutationResolvers;

use PoP\Hooks\HooksAPIInterface;
use PoP\Translation\TranslationAPIInterface;

abstract class AbstractMutationResolver implements MutationResolverInterface
{
    protected TranslationAPIInterface $translationAPI;
    protected HooksAPIInterface $hooksAPI;
    
    #[\Symfony\Contracts\Service\Attribute\Required]
    public function autowireAbstractMutationResolver(TranslationAPIInterface $translationAPI, HooksAPIInterface $hooksAPI)
    {
        $this->translationAPI = $translationAPI;
        $this->hooksAPI = $hooksAPI;
    }

    public function validateErrors(array $form_data): ?array
    {
        return null;
    }

    public function validateWarnings(array $form_data): ?array
    {
        return null;
    }

    public function getErrorType(): int
    {
        return ErrorTypes::DESCRIPTIONS;
    }
}
