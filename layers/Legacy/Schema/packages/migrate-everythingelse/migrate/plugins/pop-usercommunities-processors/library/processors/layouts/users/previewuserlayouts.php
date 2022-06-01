<?php

class GD_UserCommunities_Module_Processor_CustomPreviewUserLayouts extends PoP_Module_Processor_CustomPreviewUserLayoutsBase
{
    public final const COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_NAVIGATOR = 'layout-previewuser-community-navigator';
    public final const COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_ADDONS = 'layout-previewuser-community-addons';
    public final const COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_DETAILS = 'layout-previewuser-community-details';
    public final const COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_THUMBNAIL = 'layout-previewuser-community-thumbnail';
    public final const COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_LIST = 'layout-previewuser-community-list';
    public final const COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_MAPDETAILS = 'layout-previewuser-community-mapdetails';
    public final const COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_POPOVER = 'layout-previewuser-community-popover';
    public final const COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_COMMUNITIES = 'layout-previewuser-community-communities';
    public final const COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_POSTAUTHOR = 'layout-previewuser-community-postauthor';

    public function getComponentsToProcess(): array
    {
        return array(
            [self::class, self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_NAVIGATOR],
            [self::class, self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_ADDONS],
            [self::class, self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_DETAILS],
            [self::class, self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_THUMBNAIL],
            [self::class, self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_LIST],
            [self::class, self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_MAPDETAILS],
            [self::class, self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_POPOVER],
            [self::class, self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_COMMUNITIES],
            [self::class, self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_POSTAUTHOR],
        );
    }

    public function getQuicklinkgroupTopSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component[1]) {
            case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_THUMBNAIL:
            case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_MAPDETAILS:
            case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_POPOVER:
            case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_COMMUNITIES:
            case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_POSTAUTHOR:
            case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_DETAILS:
            case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_LIST:
                return [PoP_Module_Processor_CustomQuicklinkGroups::class, PoP_Module_Processor_CustomQuicklinkGroups::COMPONENT_QUICKLINKGROUP_USER];
        }

        return parent::getQuicklinkgroupTopSubcomponent($component);
    }

    public function getTitleHtmlmarkup(\PoP\ComponentModel\Component\Component $component, array &$props)
    {
        switch ($component[1]) {
            case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_DETAILS:
                return 'h3';
        }

        return parent::getTitleHtmlmarkup($component, $props);
    }

    public function getQuicklinkgroupBottomSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component[1]) {
            case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_NAVIGATOR:
            case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_THUMBNAIL:
            case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_MAPDETAILS:
            case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_POPOVER:
            case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_COMMUNITIES:
            case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_POSTAUTHOR:
            case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_DETAILS:
            case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_LIST:
                return [PoP_Module_Processor_CustomQuicklinkGroups::class, PoP_Module_Processor_CustomQuicklinkGroups::COMPONENT_QUICKLINKGROUP_USERBOTTOM];
        }

        return parent::getQuicklinkgroupBottomSubcomponent($component);
    }

    public function getBelowexcerptLayoutSubcomponents(\PoP\ComponentModel\Component\Component $component)
    {
        $ret = parent::getBelowexcerptLayoutSubcomponents($component);

        switch ($component[1]) {
            case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_THUMBNAIL:
                $ret[] = [PoP_Module_Processor_LocationViewComponentButtonWrapperss::class, PoP_Module_Processor_LocationViewComponentButtonWrapperss::COMPONENT_VIEWCOMPONENT_BUTTONWRAPPER_USERLOCATIONS];
                break;

            case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_MAPDETAILS:
                $ret[] = [PoP_Module_Processor_LocationViewComponentButtonWrapperss::class, PoP_Module_Processor_LocationViewComponentButtonWrapperss::COMPONENT_VIEWCOMPONENT_BUTTONWRAPPER_USERLOCATIONS_NOINITMARKERS];
                break;

            case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_DETAILS:
                $ret[] = [GD_URE_Module_Processor_MembersLayoutWrappers::class, GD_URE_Module_Processor_MembersLayoutWrappers::COMPONENT_URE_LAYOUTWRAPPER_COMMUNITYMEMBERS];
                break;
        }

        return $ret;
    }

    public function getBelowavatarLayoutSubcomponents(\PoP\ComponentModel\Component\Component $component)
    {
        $ret = parent::getBelowavatarLayoutSubcomponents($component);

        switch ($component[1]) {
            case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_DETAILS:
                $ret[] = [PoP_Module_Processor_LocationViewComponentButtonWrapperss::class, PoP_Module_Processor_LocationViewComponentButtonWrapperss::COMPONENT_VIEWCOMPONENT_BUTTONWRAPPER_USERLOCATIONS];
                break;
        }

        return $ret;
    }

    public function getUseravatarSubcomponent(\PoP\ComponentModel\Component\Component $component)
    {
        if (defined('POP_AVATARPROCESSORS_INITIALIZED')) {
            switch ($component[1]) {
                case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_COMMUNITIES:
                case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_POSTAUTHOR:
                case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_NAVIGATOR:
                case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_ADDONS:
                case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_LIST:
                    return [PoP_Module_Processor_CustomUserAvatarLayouts::class, PoP_Module_Processor_CustomUserAvatarLayouts::COMPONENT_LAYOUT_USERAVATAR_40];

                case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_POPOVER:
                    return [PoP_Module_Processor_UserAvatarLayouts::class, PoP_Module_Processor_UserAvatarLayouts::COMPONENT_LAYOUT_USERAVATAR_60];

                case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_MAPDETAILS:
                    return [PoP_Module_Processor_CustomUserAvatarLayouts::class, PoP_Module_Processor_CustomUserAvatarLayouts::COMPONENT_LAYOUT_USERAVATAR_120_RESPONSIVE];

                case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_DETAILS:
                case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_THUMBNAIL:
                    return [PoP_Module_Processor_CustomUserAvatarLayouts::class, PoP_Module_Processor_CustomUserAvatarLayouts::COMPONENT_LAYOUT_USERAVATAR_150_RESPONSIVE];
            }
        }

        return parent::getUseravatarSubcomponent($component);
    }


    public function showExcerpt(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component[1]) {
            case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_DETAILS:
                return true;
        }

        return parent::showExcerpt($component);
    }

    public function horizontalLayout(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component[1]) {
            case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_DETAILS:
                return true;
        }

        return parent::horizontalLayout($component);
    }

    public function horizontalMediaLayout(\PoP\ComponentModel\Component\Component $component)
    {
        switch ($component[1]) {
            case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_POPOVER:
            case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_COMMUNITIES:
            case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_POSTAUTHOR:
            case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_NAVIGATOR:
            case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_ADDONS:
            case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_LIST:
                return true;
        }

        return parent::horizontalMediaLayout($component);
    }

    public function getImmutableConfiguration(\PoP\ComponentModel\Component\Component $component, array &$props): array
    {
        $ret = parent::getImmutableConfiguration($component, $props);

        switch ($component[1]) {
            case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_NAVIGATOR:
            case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_THUMBNAIL:
            case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_MAPDETAILS:
            case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_POPOVER:
            case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_COMMUNITIES:
            case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_POSTAUTHOR:
                $ret[GD_JS_CLASSES]['quicklinkgroup-bottom'] = 'icon-only pull-right';
                break;
        }
        switch ($component[1]) {
            case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_DETAILS:
            case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_THUMBNAIL:
            case self::COMPONENT_LAYOUT_PREVIEWUSER_COMMUNITY_MAPDETAILS:
                $ret[GD_JS_CLASSES]['belowavatar'] = 'bg-info text-info belowavatar';
                break;
        }

        return $ret;
    }
}


