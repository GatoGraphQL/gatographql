<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $configurator) {
    $services = $configurator->services()
        ->defaults()
            ->public()
            ->autowire()
            ->autoconfigure();
    $services->load(
        'PoPSchema\\Posts\\ConditionalOnEnvironment\\AddPostTypeToCustomPostUnionTypes\\SchemaServices\\',
        '../../../src/ConditionalOnEnvironment/AddPostTypeToCustomPostUnionTypes/SchemaServices/*'
    );
};
