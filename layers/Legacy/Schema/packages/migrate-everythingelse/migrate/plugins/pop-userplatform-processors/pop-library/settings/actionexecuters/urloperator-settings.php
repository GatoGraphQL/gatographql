<?php
use PoP\Root\Facades\Instances\InstanceManagerFacade;
use PoPSitesWassup\EverythingElseMutations\SchemaServices\MutationResolvers\SettingsMutationResolver;

\PoP\Root\App::getHookManager()->addAction(
    'popcms:init',
    'gdFormatInitsettings'
);
function gdFormatInitsettings()
{
	$instanceManager = InstanceManagerFacade::getInstance();
    /** @var SettingsMutationResolver */
    $actionExecuterSettings = $instanceManager->getInstance(SettingsMutationResolver::class);
    $actionExecuterSettings->add(
    	[GD_UserPlatform_Module_Processor_SelectFormInputs::class, GD_UserPlatform_Module_Processor_SelectFormInputs::MODULE_FORMINPUT_SETTINGSFORMAT],
    	new GD_Settings_UrlOperator_Format()
    );
}
