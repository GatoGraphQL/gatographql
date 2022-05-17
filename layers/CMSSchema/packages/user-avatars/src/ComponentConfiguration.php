<?php

declare(strict_types=1);

namespace PoPCMSSchema\UserAvatars;

use PoP\Root\Module\AbstractComponentConfiguration;
use PoP\Root\Module\EnvironmentValueHelpers;

class ComponentConfiguration extends AbstractComponentConfiguration
{
    public function getUserAvatarDefaultSize(): int
    {
        $envVariable = Environment::USER_AVATAR_DEFAULT_SIZE;
        $defaultValue = 96;
        $callback = EnvironmentValueHelpers::toInt(...);

        return $this->retrieveConfigurationValueOrUseDefault(
            $envVariable,
            $defaultValue,
            $callback,
        );
    }
}
