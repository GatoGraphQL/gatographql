<?php

declare(strict_types=1);

namespace PoPSitesWassup\ContactUserMutations\MutationResolvers;

use PoP\ComponentModel\Mutation\MutationDataProviderInterface;
use PoP\GraphQLParser\Spec\Parser\Ast\WithArgumentsInterface;
use PoP_EmailSender_Utils;
use PoP\Root\Exception\AbstractException;
use PoP\Root\App;
use PoP\Application\FunctionAPIFactory;
use PoP\ComponentModel\MutationResolvers\AbstractMutationResolver;
use PoPCMSSchema\Users\TypeAPIs\UserTypeAPIInterface;

class ContactUserMutationResolver extends AbstractMutationResolver
{
    private ?UserTypeAPIInterface $userTypeAPI = null;

    final public function setUserTypeAPI(UserTypeAPIInterface $userTypeAPI): void
    {
        $this->userTypeAPI = $userTypeAPI;
    }
    final protected function getUserTypeAPI(): UserTypeAPIInterface
    {
        return $this->userTypeAPI ??= $this->instanceManager->getInstance(UserTypeAPIInterface::class);
    }

    public function validateErrors(MutationDataProviderInterface $mutationDataProvider): array
    {
        $errors = [];
        if (empty($mutationDataProvider->getValue('name'))) {
            // @todo Migrate from string to FeedbackItemProvider
            // $errors[] = new FeedbackItemResolution(
            //     MutationErrorFeedbackItemProvider::class,
            //     MutationErrorFeedbackItemProvider::E1,
            // );
            $errors[] = $this->__('Your name cannot be empty.', 'pop-genericforms');
        }

        if (empty($mutationDataProvider->getValue('email'))) {
            // @todo Migrate from string to FeedbackItemProvider
            // $errors[] = new FeedbackItemResolution(
            //     MutationErrorFeedbackItemProvider::class,
            //     MutationErrorFeedbackItemProvider::E1,
            // );
            $errors[] = $this->__('Email cannot be empty.', 'pop-genericforms');
        } elseif (!filter_var($mutationDataProvider->getValue('email'), FILTER_VALIDATE_EMAIL)) {
            // @todo Migrate from string to FeedbackItemProvider
            // $errors[] = new FeedbackItemResolution(
            //     MutationErrorFeedbackItemProvider::class,
            //     MutationErrorFeedbackItemProvider::E1,
            // );
            $errors[] = $this->__('Email format is incorrect.', 'pop-genericforms');
        }

        if (empty($mutationDataProvider->getValue('message'))) {
            // @todo Migrate from string to FeedbackItemProvider
            // $errors[] = new FeedbackItemResolution(
            //     MutationErrorFeedbackItemProvider::class,
            //     MutationErrorFeedbackItemProvider::E1,
            // );
            $errors[] = $this->__('Message cannot be empty.', 'pop-genericforms');
        }

        if (empty($mutationDataProvider->getValue('target-id'))) {
            // @todo Migrate from string to FeedbackItemProvider
            // $errors[] = new FeedbackItemResolution(
            //     MutationErrorFeedbackItemProvider::class,
            //     MutationErrorFeedbackItemProvider::E1,
            // );
            $errors[] = $this->__('The requested user cannot be empty.', 'pop-genericforms');
        } else {
            $target = $this->getUserTypeAPI()->getUserByID($mutationDataProvider->getValue('target-id'));
            if (!$target) {
                // @todo Migrate from string to FeedbackItemProvider
                // $errors[] = new FeedbackItemResolution(
                //     MutationErrorFeedbackItemProvider::class,
                //     MutationErrorFeedbackItemProvider::E1,
                // );
                $errors[] = $this->__('The requested user does not exist.', 'pop-genericforms');
            }
        }
        return $errors;
    }

    /**
     * Function to override
     */
    protected function additionals(MutationDataProviderInterface $mutationDataProvider): void
    {
        App::doAction('pop_contactuser', $mutationDataProvider);
    }

    protected function doExecute(MutationDataProviderInterface $mutationDataProvider)
    {
        $cmsapplicationapi = FunctionAPIFactory::getInstance();
        $websitename = $cmsapplicationapi->getSiteName();
        $subject = sprintf(
            $this->__('[%s]: %s', 'pop-genericforms'),
            $websitename,
            $mutationDataProvider->getValue('subject') ? $mutationDataProvider->getValue('subject') : sprintf(
                $this->__('%s sends you a message', 'pop-genericforms'),
                $mutationDataProvider->getValue('name')
            )
        );
        $placeholder = '<p><b>%s:</b> %s</p>';
        $msg = sprintf(
            '<p>%s</p>',
            sprintf(
                $this->__('You have been sent a message from a user in %s', 'pop-genericforms'),
                $websitename
            )
        ) . sprintf(
            $placeholder,
            $this->__('Name', 'pop-genericforms'),
            $mutationDataProvider->getValue('name')
        ) . sprintf(
            $placeholder,
            $this->__('Email', 'pop-genericforms'),
            sprintf(
                '<a href="mailto:%1$s">%1$s</a>',
                $mutationDataProvider->getValue('email')
            )
        ) . sprintf(
            $placeholder,
            $this->__('Subject', 'pop-genericforms'),
            $mutationDataProvider->getValue('subject')
        ) . sprintf(
            $placeholder,
            $this->__('Message', 'pop-genericforms'),
            $mutationDataProvider->getValue('message')
        );

        return PoP_EmailSender_Utils::sendemailToUser($mutationDataProvider->getValue('target-id'), $subject, $msg);
    }

    /**
     * @throws AbstractException In case of error
     */
    public function executeMutation(MutationDataProviderInterface $mutationDataProvider): mixed
    {
        $result = $this->doExecute($mutationDataProvider);

        // Allow for additional operations
        $this->additionals($mutationDataProvider);

        return $result;
    }
}
