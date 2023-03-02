(window.webpackJsonpGraphQLAPISchemaConfigurationAdditionalDocumentationPRO=window.webpackJsonpGraphQLAPISchemaConfigurationAdditionalDocumentationPRO||[]).push([[3],{48:function(e,t){e.exports='<h1 id="access-control">Access Control</h1> <p>Manage who can access every field and directive in the schema through Access Control Lists.</p> <h2 id="description">Description</h2> <p>Whenever the requested GraphQL query, either executed through a Custom Endpoint or as a Persisted Query, contains one of the selected fields or directives in the selected Access Control List(s), the corresponding list of rules is evaluated. If any rule is not satisfied, access to that field or directive is denied.</p> <p>If module <code>Public/Private Schema</code> is enabled, when access to some field or directive is denied, there are 2 ways for the API to behave:</p> <ul> <li><strong>Public mode</strong>: Provide an error message to the user, indicating why access is denied</li> <li><strong>Private mode</strong>: The error message indicates that the field or directive does not exist</li> </ul> <p>If this module is not enabled, the default behavior ir <code>Public</code>.</p> <p><img src="https://raw.githubusercontent.com/leoloso/PoP/master/layers/GraphQLAPIForWP/plugins/graphql-api-for-wp/docs-pro/implicit-features//../../images/public-private-schema.gif" alt="Public/Private schema" title="Public/Private schema"></p> <h2 id="access-control-rules">Access Control rules</h2> <p>The GraphQL API PRO plugin makes available the following access control rules:</p> <ul> <li>Disable access</li> <li>Grant access only if the user is logged-in or out</li> <li>Grant access only if the user has some role</li> <li>Grant access only if the user has some capability</li> </ul> <h2 id="using-an-access-control-list-acl">Using an Access Control List (ACL)</h2> <p>After creating the ACL (see next section), we can have the Custom Endpoint or Persisted Query use it by editing the corresponding Schema Configuration, and selecting the ACL from the list under block &quot;Access Control Lists&quot;.</p> <p><img src="https://raw.githubusercontent.com/leoloso/PoP/master/layers/GraphQLAPIForWP/plugins/graphql-api-for-wp/docs-pro/implicit-features//../../images/schema-config-access-control-lists.png" alt="Selecting an Access Control List in the Schema Configuration" title="Selecting an Access Control List in the Schema Configuration"></p> <h2 id="creating-an-access-control-list">Creating an Access Control List</h2> <p>Click on the &quot;Access Control Lists&quot; page in the GraphQL API menu, and then click on &quot;Add New Access Control List&quot;.</p> <p><img src="https://raw.githubusercontent.com/leoloso/PoP/master/layers/GraphQLAPIForWP/plugins/graphql-api-for-wp/docs-pro/implicit-features//../../images/access-control-lists.png" alt="Access Control Lists" title="Access Control Lists"></p> <p>Every Access Control List contains one or many entries, each of them with the following elements:</p> <ul> <li>The fields to grant or deny access to</li> <li>The directives to grant or deny access to</li> <li>The list of rules to validate</li> </ul> <p><img src="https://raw.githubusercontent.com/leoloso/PoP/master/layers/GraphQLAPIForWP/plugins/graphql-api-for-wp/docs-pro/implicit-features//../../images/access-control-list.png" alt="Creating an Access Control List" title="Creating an Access Control List"></p> <p>If module <code>Public/Private Schema</code> is enabled, and option <code>Enable granular control?</code> in the settings is <code>on</code>, there is an additional element:</p> <ul> <li>Public/Private Schema: behavior when access is denied</li> </ul> <p><img src="https://raw.githubusercontent.com/leoloso/PoP/master/layers/GraphQLAPIForWP/plugins/graphql-api-for-wp/docs-pro/implicit-features//../../images/settings-enable-granular-control.png" alt="Enable granular control?" title="Enable granular control?"></p> <p><img src="https://raw.githubusercontent.com/leoloso/PoP/master/layers/GraphQLAPIForWP/plugins/graphql-api-for-wp/docs-pro/implicit-features//../../images/public-private-individual-control.png" alt="Individual Public/Private schema mode" title="Individual Public/Private schema mode"></p> <p>Every entry is created by selecting the operations, fields and directives, and configuring the rules:</p> <p><img src="https://raw.githubusercontent.com/leoloso/PoP/master/layers/GraphQLAPIForWP/plugins/graphql-api-for-wp/docs-pro/implicit-features//../../images/access-control.gif" alt="Creating an Access Control List" title="Creating an Access Control List"></p> <p>Validation for fields from an interface is carried on all types implementing the interface.</p> <p><img src="https://raw.githubusercontent.com/leoloso/PoP/master/layers/GraphQLAPIForWP/plugins/graphql-api-for-wp/docs-pro/implicit-features//../../images/selecting-field-from-interface.png" alt="Creating an Access Control List" title="Selecting a field from an interface"></p> <h2 id="resources">Resources</h2> <p>Video showing how access to different fields is granted or not, according to the configuration and the user executing the query: <a href="https://vimeo.com/413503383" target="_blank">vimeo.com/413503383</a>.</p> '}}]);