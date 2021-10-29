<?php

declare(strict_types=1);

namespace PoP\Engine\ErrorHandling;

use PoP\ComponentModel\Services\BasicServiceTrait;
use Symfony\Contracts\Service\Attribute\Required;

class ErrorHelper implements ErrorHelperInterface
{
    use BasicServiceTrait;

    private ?ErrorManagerInterface $errorManager = null;

    public function setErrorManager(ErrorManagerInterface $errorManager): void
    {
        $this->errorManager = $errorManager;
    }
    protected function getErrorManager(): ErrorManagerInterface
    {
        return $this->errorManager ??= $this->getInstanceManager()->getInstance(ErrorManagerInterface::class);
    }

    public function returnResultOrConvertError(mixed $result): mixed
    {
        if ($this->getErrorManager()->isCMSError($result)) {
            return $this->getErrorManager()->convertFromCMSToPoPError((object) $result);
        }
        return $result;
    }
}
