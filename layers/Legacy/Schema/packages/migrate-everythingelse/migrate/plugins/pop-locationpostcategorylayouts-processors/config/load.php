<?php

// High priority: allow the Theme and other plug-ins to set the values in advance.
\PoP\Root\App::getHookManager()->addAction(
    'popcms:init', 
    'popLocationpostcategorylayoutsInitConstants', 
    10000
);
function popLocationpostcategorylayoutsInitConstants()
{
    include_once 'constants.php';
}
