<?php
/*
Plugin Name: PoP User Account for WordPress
Version: 0.1
Description: Implementation of WordPress functions for PoP CMS
Plugin URI: https://getpop.org/
Author: Leonardo Losoviz
*/
namespace PoP\UserAccount\WP;

//-------------------------------------------------------------------------------------
// Constants Definition
//-------------------------------------------------------------------------------------
define('POP_USERACCOUNTWP_VERSION', 0.106);
define('POP_USERACCOUNTWP_DIR', dirname(__FILE__));

class Plugin
{
    public function __construct()
    {
        include_once 'validation.php';
        \PoP\Root\App::getHookManager()->addFilter(
            'PoP_Users_Validation:provider-validation-class',
            array($this, 'getProviderValidationClass')
        );

        // Priority: mid section, after PoP User Account
        \PoP\Root\App::getHookManager()->addAction('plugins_loaded', array($this, 'init'), 888255);
    }
    public function getProviderValidationClass($class)
    {
        return Validation::class;
    }

    public function init()
    {
        if ($this->validate()) {
            $this->initialize();
            define('POP_USERACCOUNTWP_INITIALIZED', true);
        }
    }
    public function validate()
    {
        return true;
        // require_once 'validation.php';
        $validation = new Validation();
        return $validation->validate();
    }
    public function initialize()
    {
        include_once 'initialization.php';
        $initialization = new Initialization();
        return $initialization->initialize();
    }
}

/**
 * Initialization
 */
new Plugin();
