<?php

declare(strict_types=1);

namespace PoP\ComponentModel\MutationResolvers;

interface MutationResolverInterface
{
    /**
     * Please notice: the return type `mixed` includes `Error`
     */
    /**
     * @param array<string,mixed> $form_data
     * @throws \PoP\Root\Exception\AbstractException In case of error
     */
    public function executeMutation(array $form_data): mixed;
    /**
     * @return string[]
     */
    public function validateErrors(array $form_data): array;
    /**
     * @return string[]
     */
    public function validateWarnings(array $form_data): array;
    public function getErrorType(): int;
}
