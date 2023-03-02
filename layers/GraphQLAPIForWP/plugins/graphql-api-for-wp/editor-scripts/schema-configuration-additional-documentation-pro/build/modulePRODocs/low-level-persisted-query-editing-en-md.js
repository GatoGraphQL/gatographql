(window.webpackJsonpGraphQLAPISchemaConfigurationAdditionalDocumentationPRO=window.webpackJsonpGraphQLAPISchemaConfigurationAdditionalDocumentationPRO||[]).push([[19],{64:function(e,i){e.exports='<h1 id="low-level-persisted-query-editing">Low-Level Persisted Query Editing</h1> <p>Have access to directives to apply to the schema, already in the persisted query&#39;s editor.</p> <h2 id="description">Description</h2> <p>In GraphQL, directives are functions that enable to modify the result from a field. For instance, a directive <code>@strUpperCase</code> will transform the value of the field into uppercase format.</p> <p>There are 2 types of directives: those that are applied to the schema and are executed always, on every query; and those that are applied to the query, by the user or the application on the client-side.</p> <p>In the GraphQL API for WordPress, most functionality involved when resolving a query is executed through directives to be applied to the schema. </p> <p>For instance, Cache Control works by applying directive <code>@cacheControl</code> on the schema. This configuration is by default hidden, and carried out by the plugin through the user interface:</p> <p><img src="https://raw.githubusercontent.com/leoloso/PoP/master/layers/GraphQLAPIForWP/plugins/graphql-api-for-wp/docs-pro/implicit-features//../../images/cache-control.gif" alt="Defining a cache control policy" title="Defining a cache control policy"></p> <p>Similarly, these directives provide Access Control for fields (and similar directives provide Access Control for directives):</p> <ul> <li><code>@disableAccess</code></li> <li><code>@validateIsUserLoggedIn</code></li> <li><code>@validateIsUserNotLoggedIn</code></li> <li><code>@validateDoesLoggedInUserHaveAnyRole</code>.</li> <li><code>@validateDoesLoggedInUserHaveAnyCapability</code></li> </ul> <hr> <p>This module <code>Low-Level Persisted Query Editing</code> makes all directives to be applied to the schema available in the GraphiQL editor when editing persisted queries, allowing to avoid the user interface and add the schema-type directives already in the persisted query.</p> <p><img src="https://raw.githubusercontent.com/leoloso/PoP/master/layers/GraphQLAPIForWP/plugins/graphql-api-for-wp/docs-pro/implicit-features//../../images/schema-type-directives.gif" alt="Schema-type directives" title="Schema-type directives"></p> <h2 id="how-to-use">How to use</h2> <p>For instance, defining Cache Control can be done directly in the persisted query, by setting directive <code>@cacheControl</code> with argument <code>maxAge</code> on the field:</p> <p><img src="https://raw.githubusercontent.com/leoloso/PoP/master/layers/GraphQLAPIForWP/plugins/graphql-api-for-wp/docs-pro/implicit-features//../../images/low-level-persisted-query-editing.png" alt="Schema-type directives available in the Persisted queries editor" title="Schema-type directives available in the Persisted queries editor"></p> '}}]);