<?php
use PoP\ComponentModel\State\ApplicationState;

class PoP_SocialNetwork_Module_Processor_SidebarMultiples extends PoP_Module_Processor_SidebarMultiplesBase
{
    public final const MODULE_MULTIPLE_AUTHORFOLLOWERS_SIDEBAR = 'multiple-authorfollowers-sidebar';
    public final const MODULE_MULTIPLE_AUTHORFOLLOWINGUSERS_SIDEBAR = 'multiple-authorfollowingusers-sidebar';
    public final const MODULE_MULTIPLE_AUTHORSUBSCRIBEDTOTAGS_SIDEBAR = 'multiple-authorsubscribedtotags-sidebar';
    public final const MODULE_MULTIPLE_AUTHORRECOMMENDEDPOSTS_SIDEBAR = 'multiple-authorrecommendedposts-sidebar';

    public function getComponentsToProcess(): array
    {
        return array(
            [self::class, self::MODULE_MULTIPLE_AUTHORFOLLOWERS_SIDEBAR],
            [self::class, self::MODULE_MULTIPLE_AUTHORFOLLOWINGUSERS_SIDEBAR],
            [self::class, self::MODULE_MULTIPLE_AUTHORSUBSCRIBEDTOTAGS_SIDEBAR],
            [self::class, self::MODULE_MULTIPLE_AUTHORRECOMMENDEDPOSTS_SIDEBAR],
        );
    }

    public function getInnerSubmodules(array $component): array
    {
        $ret = parent::getInnerSubmodules($component);

        switch ($component[1]) {
         // Add also the filter block for the Single Related Content, etc
            case self::MODULE_MULTIPLE_AUTHORFOLLOWERS_SIDEBAR:
            case self::MODULE_MULTIPLE_AUTHORFOLLOWINGUSERS_SIDEBAR:
            case self::MODULE_MULTIPLE_AUTHORSUBSCRIBEDTOTAGS_SIDEBAR:
            case self::MODULE_MULTIPLE_AUTHORRECOMMENDEDPOSTS_SIDEBAR:
                $author = \PoP\Root\App::getState(['routing', 'queried-object-id']);
                $filters = array(
                    self::MODULE_MULTIPLE_AUTHORFOLLOWERS_SIDEBAR => [PoP_Module_Processor_SidebarMultipleInners::class, PoP_Module_Processor_SidebarMultipleInners::MODULE_MULTIPLE_SECTIONINNER_USERS_SIDEBAR],
                    self::MODULE_MULTIPLE_AUTHORFOLLOWINGUSERS_SIDEBAR => [PoP_Module_Processor_SidebarMultipleInners::class, PoP_Module_Processor_SidebarMultipleInners::MODULE_MULTIPLE_SECTIONINNER_USERS_SIDEBAR],
                    self::MODULE_MULTIPLE_AUTHORSUBSCRIBEDTOTAGS_SIDEBAR => [PoP_Module_Processor_SidebarMultipleInners::class, PoP_Module_Processor_SidebarMultipleInners::MODULE_MULTIPLE_SECTIONINNER_AUTHORTAGS_SIDEBAR],
                    self::MODULE_MULTIPLE_AUTHORRECOMMENDEDPOSTS_SIDEBAR => [PoP_Module_Processor_SidebarMultipleInners::class, PoP_Module_Processor_SidebarMultipleInners::MODULE_MULTIPLE_SECTIONINNER_CONTENT_SIDEBAR],
                );
                if ($filter = $filters[$component[1]] ?? null) {
                    $ret[] = $filter;
                }

                // Allow URE to add the Organization/Individual sidebars below
                $ret = \PoP\Root\App::applyFilters(
                    'PoP_UserCommunities_Module_Processor_SidebarMultiples:sidebar-layouts',
                    $ret,
                    $author,
                    $component
                );
                break;
        }

        return $ret;
    }

    public function getScreen(array $component)
    {
        $screens = array(
            self::MODULE_MULTIPLE_AUTHORFOLLOWERS_SIDEBAR => POP_SCREEN_AUTHORUSERS,
            self::MODULE_MULTIPLE_AUTHORFOLLOWINGUSERS_SIDEBAR => POP_SCREEN_AUTHORUSERS,
            self::MODULE_MULTIPLE_AUTHORSUBSCRIBEDTOTAGS_SIDEBAR => POP_SCREEN_AUTHORTAGS,
            self::MODULE_MULTIPLE_AUTHORRECOMMENDEDPOSTS_SIDEBAR => POP_SCREEN_AUTHORSECTION,
        );
        if ($screen = $screens[$component[1]] ?? null) {
            return $screen;
        }

        return parent::getScreen($component);
    }

    public function getScreengroup(array $component)
    {
        switch ($component[1]) {
            case self::MODULE_MULTIPLE_AUTHORFOLLOWERS_SIDEBAR:
            case self::MODULE_MULTIPLE_AUTHORFOLLOWINGUSERS_SIDEBAR:
            case self::MODULE_MULTIPLE_AUTHORSUBSCRIBEDTOTAGS_SIDEBAR:
            case self::MODULE_MULTIPLE_AUTHORRECOMMENDEDPOSTS_SIDEBAR:
                return POP_SCREENGROUP_CONTENTREAD;
        }

        return parent::getScreengroup($component);
    }
}


