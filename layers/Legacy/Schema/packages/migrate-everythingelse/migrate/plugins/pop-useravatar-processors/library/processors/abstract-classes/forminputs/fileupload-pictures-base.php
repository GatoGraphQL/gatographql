<?php
use PoP\Root\Facades\Translation\TranslationAPIFacade;

abstract class PoP_Module_Processor_FileUploadPicturesBase extends PoPEngine_QueryDataComponentProcessorBase
{
    public function getTemplateResource(array $componentVariation, array &$props): ?array
    {
        return [PoP_UserAvatarWebPlatform_TemplateResourceLoaderProcessor::class, PoP_UserAvatarWebPlatform_TemplateResourceLoaderProcessor::RESOURCE_FILEUPLOAD_PICTURE];
    }

    public function getSubComponentVariations(array $componentVariation): array
    {
        return array(
            $this->getDownloadpictureSubmodule($componentVariation),
            $this->getUploadpictureSubmodule($componentVariation),
        );
    }

    public function getDownloadpictureSubmodule(array $componentVariation)
    {
        return [PoP_Module_Processor_DownloadPictureFileUpload::class, PoP_Module_Processor_DownloadPictureFileUpload::MODULE_FILEUPLOAD_PICTURE_DOWNLOAD];
    }

    public function getUploadpictureSubmodule(array $componentVariation)
    {
        return [PoP_Module_Processor_UploadPictureFileUpload::class, PoP_Module_Processor_UploadPictureFileUpload::MODULE_FILEUPLOAD_PICTURE_UPLOAD];
    }

    public function getDefaultAvatarUserId(array $componentVariation, array &$props)
    {
        return POP_AVATAR_GENERICAVATARUSER;
    }

    public function getJsmethods(array $componentVariation, array &$props)
    {
        $ret = parent::getJsmethods($componentVariation, $props);
        $this->addJsmethod($ret, 'fileUpload');
        return $ret;
    }

    public function initModelProps(array $componentVariation, array &$props): void
    {

        // // The downloadpicture module will need to be rendered dynamically on runtime
        // $downloadpicture_componentVariation = $this->getDownloadpictureSubmodule($componentVariation);
        // $this->setProp($downloadpicture_componentVariation, $props, 'module-path', true);
        $this->setProp($downloadpicture_componentVariation, $props, 'dynamic-module', true);

        $this->appendProp($componentVariation, $props, 'class', 'pop-fileupload');

        // Load the picture immediately
        $this->appendProp($componentVariation, $props, 'class', 'pop-fileupload-loadfromserver');

        parent::initModelProps($componentVariation, $props);
    }

    public function getImmutableConfiguration(array $componentVariation, array &$props): array
    {
        $ret = parent::getImmutableConfiguration($componentVariation, $props);

        $ret['module-download'] = $this->getDownloadpictureSubmodule($componentVariation);
        $ret['module-upload'] = $this->getUploadpictureSubmodule($componentVariation);

        $ret[GD_JS_TITLES] = array(
            'avatar' => TranslationAPIFacade::getInstance()->__('Avatar', 'pop-useravatar-processors'),
            'photo' => TranslationAPIFacade::getInstance()->__('Profile photo', 'pop-useravatar-processors'),
            'upload' => TranslationAPIFacade::getInstance()->__('Upload photo', 'pop-useravatar-processors')
        );

        $default_avatar_user_id = $this->getDefaultAvatarUserId($componentVariation, $props);

        // Add the default Avatar, when no picture was yet uploaded
        $pluginapi = PoP_Avatar_FunctionsAPIFactory::getInstance();
        $avatar = $pluginapi->getAvatar($default_avatar_user_id, 150);
        // $avatar_original = gd_user_avatar_original_file($avatar, $default_avatar_user_id, 150);
        $userphoto = gdGetAvatarPhotoinfo($default_avatar_user_id);

        $ret['default-thumb'] = array(
            'url' => gdAvatarExtractUrl($avatar),
            'size' => 150,
        );
        $ret['default-image'] = array(
            'url' => $userphoto['src'],
            'width' => $userphoto['width'],
            'height' => $userphoto['height'],
        );

        if ($rel = gdImageRel()) {
            $ret['image-rel'] = $rel;
        }

        return $ret;
    }

    /**
     * @todo Migrate from string to LeafModuleField
     *
     * @return \PoP\ComponentModel\GraphQLEngine\Model\ComponentModelSpec\LeafModuleField[]
     */
    public function getDataFields(array $componentVariation, array &$props): array
    {
        return array(
            'fileUploadPictureURL',
        );
    }
}
