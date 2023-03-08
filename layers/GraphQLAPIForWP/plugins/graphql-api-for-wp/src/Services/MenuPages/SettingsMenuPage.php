<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\Services\MenuPages;

use GraphQLAPI\GraphQLAPI\Constants\ModuleSettingOptions;
use GraphQLAPI\GraphQLAPI\Constants\RequestParams;
use GraphQLAPI\GraphQLAPI\Constants\ResetSettingsOptions;
use GraphQLAPI\GraphQLAPI\Facades\UserSettingsManagerFacade;
use GraphQLAPI\GraphQLAPI\ModuleResolvers\PluginGeneralSettingsFunctionalityModuleResolver;
use GraphQLAPI\GraphQLAPI\ModuleResolvers\PluginManagementFunctionalityModuleResolver;
use GraphQLAPI\GraphQLAPI\ModuleSettings\Properties;
use GraphQLAPI\GraphQLAPI\Settings\Options;
use GraphQLAPI\GraphQLAPI\Settings\SettingsNormalizerInterface;
use GraphQLAPI\GraphQLAPI\Settings\UserSettingsManagerInterface;
use PoP\Root\App;

/**
 * Settings menu page
 */
class SettingsMenuPage extends AbstractPluginMenuPage
{
    use UseTabpanelMenuPageTrait;
    use UseDocsMenuPageTrait;

    public final const FORM_ORIGIN = 'form-origin';
    public final const SETTINGS_FIELD = 'graphql-api-settings';
    public final const RESET_SETTINGS_BUTTON_ID = 'submit-reset-settings';

    private ?UserSettingsManagerInterface $userSettingsManager = null;
    private ?SettingsNormalizerInterface $settingsNormalizer = null;
    private ?PluginManagementFunctionalityModuleResolver $pluginManagementFunctionalityModuleResolver = null;

    public function setUserSettingsManager(UserSettingsManagerInterface $userSettingsManager): void
    {
        $this->userSettingsManager = $userSettingsManager;
    }
    protected function getUserSettingsManager(): UserSettingsManagerInterface
    {
        return $this->userSettingsManager ??= UserSettingsManagerFacade::getInstance();
    }
    final public function setSettingsNormalizer(SettingsNormalizerInterface $settingsNormalizer): void
    {
        $this->settingsNormalizer = $settingsNormalizer;
    }
    final protected function getSettingsNormalizer(): SettingsNormalizerInterface
    {
        /** @var SettingsNormalizerInterface */
        return $this->settingsNormalizer ??= $this->instanceManager->getInstance(SettingsNormalizerInterface::class);
    }
    final public function setPluginManagementFunctionalityModuleResolver(PluginManagementFunctionalityModuleResolver $pluginManagementFunctionalityModuleResolver): void
    {
        $this->pluginManagementFunctionalityModuleResolver = $pluginManagementFunctionalityModuleResolver;
    }
    final protected function getPluginManagementFunctionalityModuleResolver(): PluginManagementFunctionalityModuleResolver
    {
        /** @var PluginManagementFunctionalityModuleResolver */
        return $this->pluginManagementFunctionalityModuleResolver ??= $this->instanceManager->getInstance(PluginManagementFunctionalityModuleResolver::class);
    }

    public function getMenuPageSlug(): string
    {
        return 'settings';
    }

    /**
     * Initialize the class instance
     */
    public function initialize(): void
    {
        parent::initialize();

        /**
         * Before saving the settings in the DB,
         * decide what it is that must be stored.
         * There are 2 options.
         *
         * 1. If button "submit-reset-settings" is sent,
         * then the "Reset Settings" button has been pressed.
         * Then remove all settings values, except for the
         * safe/unsafe default value
         * 
         * 2. Otherwise, it's the normal Settings.
         */
        $option = self::SETTINGS_FIELD;
        \add_filter(
            "pre_update_option_{$option}",
            /**
             * @param array<string,mixed> $values
             * @return array<string,mixed>
             */
            function (array $values): array {
                $resetSettingsOptionName = $this->getPluginManagementFunctionalityModuleResolver()->getSettingOptionName(
                    PluginManagementFunctionalityModuleResolver::PLUGIN_MANAGEMENT,
                    PluginManagementFunctionalityModuleResolver::OPTION_RESET_SETTINGS_SAFE_UNSAFE_BEHAVIOR
                );
                /**
                 * 1st case: check that pressed on the "Reset Settings" button,
                 * and an actual "safe" or "unsafe" value was selected.
                 */
                if (isset($values[self::RESET_SETTINGS_BUTTON_ID])
                    && in_array(
                        $values[$resetSettingsOptionName] ?? null,
                        [
                            ResetSettingsOptions::SAFE,
                            ResetSettingsOptions::UNSAFE,
                        ]
                    )
                ) {
                    $values = array_intersect_key(
                        $values,
                        [
                            $resetSettingsOptionName => ''
                        ]
                    );
                } else {
                    /**
                     * Execute the callback sanitazation here,
                     * and not on entry 'sanitize_callback' from `register_setting`,
                     * because that one will be called twice: once triggered
                     * by `update_option` and once by `add_option`,
                     * with `add_option` happening after the extra logic here
                     * (i.e. added on `pre_update_option_{$option}`) has taken
                     * place, which means that it undoes this logic that sets
                     * the state for "reset the settings".
                     *
                     * This call is needed to cast the data
                     * before saving to the DB.
                     */
                    $values = $this->getSettingsNormalizer()->normalizeSettings($values);
                    /**
                     * If haven't clicked on the "Reset Settings" button,
                     * then do not override the whatever value was selected
                     */
                    unset($values[$resetSettingsOptionName]);
                }
                
                return $values;
            }
        );

        /**
         * After saving the settings in the DB:
         * - Flush the rewrite rules, so different URL slugs take effect
         * - Update the timestamp
         *
         * This hooks is also triggered the first time the user saves the settings
         * (i.e. there's no update) thanks to `maybeStoreEmptySettings`
         */
        \add_action(
            "update_option_{$option}",
            function (): void {
                \flush_rewrite_rules();

                // Update the timestamp
                $this->getUserSettingsManager()->storeContainerTimestamp();
            }
        );

        /**
         * Register the settings
         */
        \add_action(
            'admin_init',
            function (): void {
                $items = $this->getSettingsNormalizer()->getAllSettingsItems();
                foreach ($items as $item) {
                    $settingsFieldForModule = $this->getSettingsFieldForModule($item['id']);
                    $module = $item['module'];
                    \add_settings_section(
                        $settingsFieldForModule,
                        // The empty string ensures the render function won't output a h2.
                        '',
                        function (): void {
                        },
                        self::SETTINGS_FIELD
                    );
                    foreach ($item['settings'] as $itemSetting) {
                        \add_settings_field(
                            $itemSetting[Properties::NAME],
                            $itemSetting[Properties::TITLE] ?? '',
                            function () use ($module, $itemSetting): void {
                                $type = $itemSetting[Properties::TYPE] ?? null;
                                $possibleValues = $itemSetting[Properties::POSSIBLE_VALUES] ?? [];
                                if (!empty($possibleValues)) {
                                    $this->printSelectField($module, $itemSetting);
                                } elseif ($type === Properties::TYPE_ARRAY) {
                                    $this->printTextareaField($module, $itemSetting);
                                } elseif ($type === Properties::TYPE_BOOL) {
                                    $this->printCheckboxField($module, $itemSetting);
                                } elseif ($type === Properties::TYPE_NULL) {
                                    $this->printLabelField($module, $itemSetting);
                                } else {
                                    $this->printInputField($module, $itemSetting);
                                }
                            },
                            self::SETTINGS_FIELD,
                            $settingsFieldForModule,
                            [
                                'label' => $itemSetting[Properties::DESCRIPTION] ?? '',
                                'id' => $itemSetting[Properties::NAME],
                            ]
                        );
                    }
                }

                /**
                 * Finally register all the settings
                 */
                \register_setting(
                    self::SETTINGS_FIELD,
                    Options::SETTINGS,
                    [
                        'type' => 'array',
                        'description' => \__('Settings for the GraphQL API', 'graphql-api'),
                        /**
                         * Don't execute the callback sanitazation here,
                         * because it will be called twice: once triggered
                         * by `update_option` and once by `add_option`,
                         * with `add_option` happening after the extra logic
                         * added by `pre_update_option_{$option}` has taken
                         * place, which means that it undoes the logic added
                         * on that hook to set the state for "reset the settings".
                         *
                         * Then, the sanitazation is also executed on that hook.
                         */
                        // // This call is needed to cast the data
                        // // before saving to the DB
                        // 'sanitize_callback' => $this->getSettingsNormalizer()->normalizeSettings(...),
                        'show_in_rest' => false,
                    ]
                );
            }
        );
    }

    protected function getSettingsFieldForModule(string $moduleID): string
    {
        return self::SETTINGS_FIELD . '-' . $moduleID;
    }

    /**
     * The user can define this behavior through the Settings.
     * If `true`, print the sections using tabs
     * If `false`, print the sections one below the other
     */
    protected function printWithTabs(): bool
    {
        return $this->getUserSettingsManager()->getSetting(
            PluginGeneralSettingsFunctionalityModuleResolver::GENERAL,
            PluginGeneralSettingsFunctionalityModuleResolver::OPTION_PRINT_SETTINGS_WITH_TABS
        );
    }

    /**
     * Print the settings form
     */
    public function print(): void
    {
        $items = $this->getSettingsNormalizer()->getAllSettingsItems();
        if (!$items) {
            _e('There are no items to be configured', 'graphql-api');
            return;
        }

        $printWithTabs = $this->printWithTabs();
        // By default, focus on the first module
        $activeModuleID = $items[0]['id'];
        // If passing a tab, focus on that one, if the module exists
        $tab = App::query(RequestParams::TAB);
        if ($tab !== null) {
            $moduleIDs = array_map(
                fn ($item) => $item['id'],
                $items
            );
            if (in_array($tab, $moduleIDs)) {
                $activeModuleID = $tab;
            }
        }
        $class = 'wrap vertical-tabs';
        if ($printWithTabs) {
            $class .= ' graphql-api-tabpanel';
        }
        ?>
        <div
            id="graphql-api-settings"
            class="<?php echo $class ?>"
        >
            <h1><?php \_e('GraphQL API — Settings', 'graphql-api'); ?></h1>
            <?php \settings_errors(); ?>

            <?php if ($printWithTabs) : ?>
                <div class="nav-tab-container">
                    <!-- Tabs -->
                    <h2 class="nav-tab-wrapper">
                        <?php
                        foreach ($items as $item) {
                            printf(
                                '<a href="#%s" class="nav-tab %s">%s</a>',
                                $item['id'],
                                $item['id'] === $activeModuleID ? 'nav-tab-active' : '',
                                $item['name']
                            );
                        }
                        ?>
                    </h2>
                    <div class="nav-tab-content">
            <?php endif; ?>
                        <form method="post" action="options.php">
                            <!-- Artificial input as flag that the form belongs to this plugin -->
                            <input type="hidden" name="<?php echo self::FORM_ORIGIN ?>" value="<?php echo self::SETTINGS_FIELD ?>" />
                            <!--
                                Artificial input to trigger the update of the form always, as to always purge the container/operational cache
                                (eg: to include 3rd party extensions in the service container, or new Gutenberg blocks)
                                This is needed because "If the new and old values are the same, no need to update."
                                which makes "update_option_{$option}" not be triggered when there are no changes
                                @see wp-includes/option.php
                            -->
                            <input type="hidden" name="<?php echo self::SETTINGS_FIELD?>[last_saved_timestamp]" value="<?php echo time() ?>">
                            <!-- Panels -->
                            <?php
                            $sectionClass = $printWithTabs ? 'tab-content' : '';
                            \settings_fields(self::SETTINGS_FIELD);
                            foreach ($items as $item) {
                                $sectionStyle = '';
                                $maybeTitle = $printWithTabs
                                    ? sprintf(
                                        '<h2>%s</h2><hr/>',
                                        $item['name']
                                    ) : sprintf(
                                        '<br/><hr/><br/><h2 id="%s">%s</h2>',
                                        $item['id'],
                                        $item['name']
                                    );
                                if ($printWithTabs) {
                                    $sectionStyle = sprintf(
                                        'display: %s;',
                                        $item['id'] === $activeModuleID ? 'block' : 'none'
                                    );
                                }
                                ?>
                                <div id="<?php echo $item['id'] ?>" class="<?php echo $sectionClass ?>" style="<?php echo $sectionStyle ?>">
                                    <?php echo $maybeTitle ?>
                                    <table class="form-table">
                                        <?php \do_settings_fields(self::SETTINGS_FIELD, $this->getSettingsFieldForModule($item['id'])) ?>
                                    </table>
                                </div>
                                <?php
                            }
                            \submit_button(
                                \__('Save Changes (All)', 'graphql-api')
                            );
        ?>
                        </form>
            <?php if ($printWithTabs) : ?>
                    </div> <!-- class="nav-tab-content" -->
                </div> <!-- class="nav-tab-container" -->
            <?php endif; ?>
        </div>
        <?php
    }

    /**
     * Enqueue the required assets and initialize the localized scripts
     */
    protected function enqueueAssets(): void
    {
        parent::enqueueAssets();

        $this->enqueueDocsAssets();

        if ($this->printWithTabs()) {
            $this->enqueueTabpanelAssets();
        }
    }

    /**
     * Get the option value
     */
    protected function getOptionValue(string $module, string $option): mixed
    {
        return $this->getUserSettingsManager()->getSetting($module, $option);
    }

    /**
     * Display a checkbox field.
     *
     * @param array<string,mixed> $itemSetting
     */
    protected function printCheckboxField(string $module, array $itemSetting): void
    {
        $name = $itemSetting[Properties::NAME];
        $input = $itemSetting[Properties::INPUT];
        $value = $this->getOptionValue($module, $input);
        ?>
            <label for="<?php echo $name; ?>">
                <input type="checkbox" name="<?php echo self::SETTINGS_FIELD . '[' . $name . ']'; ?>" id="<?php echo $name; ?>" value="1" <?php checked(1, $value); ?> />
                <?php echo $itemSetting[Properties::DESCRIPTION] ?? ''; ?>
            </label>
        <?php
    }

    /**
     * Display a label
     *
     * @param array<string,mixed> $itemSetting
     */
    protected function printLabelField(string $module, array $itemSetting): void
    {
        ?>
            <p>
                <?php echo $itemSetting[Properties::DESCRIPTION] ?? ''; ?>
            </p>
        <?php
    }

    /**
     * Display an input field.
     *
     * @param array<string,mixed> $itemSetting
     */
    protected function printInputField(string $module, array $itemSetting): void
    {
        $name = $itemSetting[Properties::NAME];
        $input = $itemSetting[Properties::INPUT];
        $value = $this->getOptionValue($module, $input);
        $label = isset($itemSetting[Properties::DESCRIPTION]) ? '<br/>' . $itemSetting[Properties::DESCRIPTION] : '';
        $isNumber = isset($itemSetting[Properties::TYPE]) && $itemSetting[Properties::TYPE] === Properties::TYPE_INT;
        $minNumber = null;
        if ($isNumber) {
            $minNumber = $itemSetting[Properties::MIN_NUMBER] ?? null;
        }
        ?>
            <label for="<?php echo $name; ?>">
                <input name="<?php echo self::SETTINGS_FIELD . '[' . $name . ']'; ?>" id="<?php echo $name; ?>" value="<?php echo $value; ?>" <?php echo $isNumber ? ('type="number" step="1"' . (!is_null($minNumber) ? ' min="' . $minNumber . '"' : '')) : 'type="text"' ?>/>
                <?php echo $label; ?>
            </label>
        <?php
    }

    /**
     * Display a select field.
     *
     * @param array<string,mixed> $itemSetting
     */
    protected function printSelectField(string $module, array $itemSetting): void
    {
        $name = $itemSetting[Properties::NAME];
        $input = $itemSetting[Properties::INPUT];
        $value = $this->getOptionValue($module, $input);
        // If it is multiple, $value is an array.
        // To simplify, deal always with arrays
        if (!is_array($value)) {
            $value = is_null($value) ? [] : [$value];
        }
        $label = isset($itemSetting[Properties::DESCRIPTION]) ? '<br/>' . $itemSetting[Properties::DESCRIPTION] : '';
        $isMultiple = $itemSetting[Properties::IS_MULTIPLE] ?? false;
        $possibleValues = $itemSetting[Properties::POSSIBLE_VALUES] ?? [];
        ?>
            <label for="<?php echo $name; ?>">
                <select name="<?php echo self::SETTINGS_FIELD . '[' . $name . ']' . ($isMultiple ? '[]' : ''); ?>" id="<?php echo $name; ?>" <?php echo $isMultiple ? 'multiple="multiple" size="10"' : ''; ?>>
                <?php foreach ($possibleValues as $optionValue => $optionLabel) : ?>
                    <?php $maybeSelected = in_array($optionValue, $value) ? 'selected="selected"' : ''; ?>
                    <option value="<?php echo $optionValue ?>" <?php echo $maybeSelected ?>>
                        <?php echo $optionLabel ?>
                    </option>
                <?php endforeach ?>
                </select>
                <?php echo $label; ?>
            </label>
        <?php
    }

    /**
     * Display a textarea field.
     *
     * @param array<string,mixed> $itemSetting
     */
    protected function printTextareaField(string $module, array $itemSetting): void
    {
        $name = $itemSetting[Properties::NAME];
        $input = $itemSetting[Properties::INPUT];
        // This must be an array
        $value = $this->getOptionValue($module, $input);
        $label = isset($itemSetting[Properties::DESCRIPTION]) ? '<br/>' . $itemSetting[Properties::DESCRIPTION] : '';
        ?>
            <label for="<?php echo $name; ?>">
                <textarea name="<?php echo self::SETTINGS_FIELD . '[' . $name . ']'; ?>" id="<?php echo $name; ?>" rows="10" cols="40"><?php echo implode("\n", $value) ?></textarea>
                <?php echo $label; ?>
            </label>
        <?php
    }
}
