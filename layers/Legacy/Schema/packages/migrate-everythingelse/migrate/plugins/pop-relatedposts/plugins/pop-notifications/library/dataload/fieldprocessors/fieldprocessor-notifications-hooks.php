<?php
use PoP\ComponentModel\FieldResolvers\ObjectType\AbstractObjectTypeFieldResolver;
use PoP\ComponentModel\Misc\RequestUtils;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\TypeResolvers\RelationalTypeResolverInterface;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoPSchema\CustomPosts\Facades\CustomPostTypeAPIFacade;
use PoPSchema\Notifications\TypeResolvers\ObjectType\NotificationObjectTypeResolver;
use PoPSchema\Users\Facades\UserTypeAPIFacade;

class PoP_RelatedPosts_AAL_PoP_DataLoad_ObjectTypeFieldResolver_Notifications extends AbstractObjectTypeFieldResolver
{
    public function getObjectTypeResolverClassesToAttachTo(): array
    {
        return [
            NotificationObjectTypeResolver::class,
        ];
    }

    public function getFieldNamesToResolve(): array
    {
        return [
            'icon',
            'url',
            'message',
        ];
    }

    public function getSchemaFieldType(RelationalTypeResolverInterface $relationalTypeResolver, string $fieldName): string
    {
        $types = [
            'icon' => SchemaDefinition::TYPE_STRING,
            'url' => SchemaDefinition::TYPE_URL,
            'message' => SchemaDefinition::TYPE_STRING,
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($relationalTypeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(RelationalTypeResolverInterface $relationalTypeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
            'icon' => $translationAPI->__('', ''),
            'url' => $translationAPI->__('', ''),
            'message' => $translationAPI->__('', ''),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($relationalTypeResolver, $fieldName);
    }

    /**
     * @param array<string, mixed> $fieldArgs
     */
    public function resolveCanProcessResultItem(
        RelationalTypeResolverInterface $relationalTypeResolver,
        object $object,
        string $fieldName,
        array $fieldArgs = []
    ): bool {
        $notification = $object;
        return $notification->object_type == 'Post' && in_array(
            $notification->action,
            [
                AAL_POP_ACTION_POST_REFERENCEDPOST,
            ]
        );
    }

    /**
     * @param array<string, mixed> $fieldArgs
     * @param array<string, mixed>|null $variables
     * @param array<string, mixed>|null $expressions
     * @param array<string, mixed> $options
     */
    public function resolveValue(
        RelationalTypeResolverInterface $relationalTypeResolver,
        object $object,
        string $fieldName,
        array $fieldArgs = [],
        ?array $variables = null,
        ?array $expressions = null,
        array $options = []
    ): mixed {
        $userTypeAPI = UserTypeAPIFacade::getInstance();
        $customPostTypeAPI = CustomPostTypeAPIFacade::getInstance();
        $notification = $object;
        switch ($fieldName) {
            case 'icon':
                $routes = array(
                    AAL_POP_ACTION_POST_REFERENCEDPOST => POP_RELATEDPOSTS_ROUTE_RELATEDCONTENT,
                );
                return getRouteIcon($routes[$notification->action], false);

            case 'url':
                switch ($notification->action) {
                    case AAL_POP_ACTION_POST_REFERENCEDPOST:
                        // Can't point to the posted article since we don't have the information (object_id is the original, referenced post, not the referencing one),
                        // so the best next thing is to point to the tab of all related content of the original post
                        $value = $customPostTypeAPI->getPermalink($notification->object_id);
                        if (POP_RELATEDPOSTS_ROUTE_RELATEDCONTENT) {
                            $value = RequestUtils::addRoute($value, POP_RELATEDPOSTS_ROUTE_RELATEDCONTENT);
                        }
                        return $value;
                }
                return null;

            case 'message':
                $messages = array(
                    AAL_POP_ACTION_POST_REFERENCEDPOST => TranslationAPIFacade::getInstance()->__('<strong>%1$s</strong> posted content related to %2$s <strong>%3$s</strong>', 'aal-pop'),
                );
                return sprintf(
                    $messages[$notification->action],
                    $userTypeAPI->getUserDisplayName($notification->user_id),
                    gdGetPostname($notification->object_id, 'lc'), //strtolower(gdGetPostname($notification->object_id)),
                    $notification->object_name
                );
        }

        return parent::resolveValue($relationalTypeResolver, $object, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }
}

// Static Initialization: Attach
(new PoP_RelatedPosts_AAL_PoP_DataLoad_ObjectTypeFieldResolver_Notifications())->attach(\PoP\ComponentModel\AttachableExtensions\AttachableExtensionGroups::OBJECT_TYPE_FIELD_RESOLVERS, 20);
