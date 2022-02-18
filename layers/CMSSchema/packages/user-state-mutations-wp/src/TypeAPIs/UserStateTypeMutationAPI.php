<?php

declare(strict_types=1);

namespace PoPCMSSchema\UserStateMutationsWP\TypeAPIs;

use PoP\Root\Services\BasicServiceTrait;
use PoPCMSSchema\SchemaCommons\Error\ErrorHelperInterface;
use PoPCMSSchema\UserStateMutations\Exception\UserStateMutationException;
use PoPCMSSchema\UserStateMutations\TypeAPIs\UserStateTypeMutationAPIInterface;
use WP_Error;

/**
 * Methods to interact with the Type, to be implemented by the underlying CMS
 */
class UserStateTypeMutationAPI implements UserStateTypeMutationAPIInterface
{
    use BasicServiceTrait;

    private ?ErrorHelperInterface $errorHelper = null;

    final public function setErrorHelper(ErrorHelperInterface $errorHelper): void
    {
        $this->errorHelper = $errorHelper;
    }
    final protected function getErrorHelper(): ErrorHelperInterface
    {
        return $this->errorHelper ??= $this->instanceManager->getInstance(ErrorHelperInterface::class);
    }

    /**
     * @return mixed Result or Error
     */
    public function login(array $credentials): mixed
    {
        // Convert params
        if (isset($credentials['login'])) {
            $credentials['user_login'] = $credentials['login'];
            unset($credentials['login']);
        }
        if (isset($credentials['password'])) {
            $credentials['user_password'] = $credentials['password'];
            unset($credentials['password']);
        }
        if (isset($credentials['remember'])) {
            // Same param name, so do nothing
        }
        $result = \wp_signon($credentials);

        if ($result instanceof WP_Error) {
            throw new UserStateMutationException(
                $result->get_error_message()
            );
        }

        $user = $result;
        \wp_set_current_user($user->ID);

        return $result;
    }

    public function logout(): void
    {
        \wp_logout();

        // Delete the current user, so that it already says "user not logged in" for the toplevel feedback
        global $current_user;
        $current_user = null;
        \wp_set_current_user(0);
    }
}
