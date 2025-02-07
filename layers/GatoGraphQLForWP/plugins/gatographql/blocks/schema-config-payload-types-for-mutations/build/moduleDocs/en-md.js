(globalThis.webpackChunkschema_config_payload_types_for_mutations=globalThis.webpackChunkschema_config_payload_types_for_mutations||[]).push([[882],{53:s=>{s.exports='<h1 id="mutations">Mutations</h1> <p>Mutations are operations that have side effects, such as performing an insert or update of data in the database. The available mutation fields are those under the <code>MutationRoot</code> type (or some of the fields under <code>Root</code> when using nested mutations), and these can be executed in the GraphQL document via the operation type <code>mutation</code>:</p> <pre><code class="hljs language-graphql"><span class="hljs"><span class="hljs-keyword">mutation</span> <span class="hljs-punctuation">{</span>\n  updatePost<span class="hljs-punctuation">(</span><span class="hljs-symbol">input</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n    <span class="hljs-symbol">id</span><span class="hljs-punctuation">:</span> <span class="hljs-number">5</span>,\n    <span class="hljs-symbol">title</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;New title&quot;</span>\n  <span class="hljs-punctuation">}</span><span class="hljs-punctuation">)</span> <span class="hljs-punctuation">{</span>\n    title\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <p>The <strong>Mutations</strong> module acts as an upstream dependency for all modules containing mutations. This allows us to remove all mutations from the GraphQL schema simply by disabling this module.</p> <h2 id="returning-a-payload-object-or-the-mutated-entity">Returning a Payload Object or the Mutated Entity</h2> <p>Mutation fields can be configured to return either of these 2 different entities:</p> <ul> <li>A payload object type</li> <li>Directly the mutated entity</li> </ul> <h3 id="payload-object-type">Payload object type</h3> <p>A payload object type contains all the data concerning the mutation:</p> <ul> <li>The status of the mutation (success or failure)</li> <li>The errors (if any) using distinctive GraphQL types, or</li> <li>The successfully mutated entity</li> </ul> <p>For instance, mutation <code>updatePost</code> returns an object of type <code>PostUpdateMutationPayload</code> (please notice that we still need to query its field <code>post</code> to retrieve the updated post entity):</p> <pre><code class="hljs language-graphql"><span class="hljs"><span class="hljs-keyword">mutation</span> UpdatePost <span class="hljs-punctuation">{</span>\n  updatePost<span class="hljs-punctuation">(</span><span class="hljs-symbol">input</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n    <span class="hljs-symbol">id</span><span class="hljs-punctuation">:</span> <span class="hljs-number">1724</span>,\n    <span class="hljs-symbol">title</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;New title&quot;</span>,\n    <span class="hljs-symbol">status</span><span class="hljs-punctuation">:</span> publish\n  <span class="hljs-punctuation">}</span><span class="hljs-punctuation">)</span> <span class="hljs-punctuation">{</span>\n    <span class="hljs-comment"># This is the status of the mutation: SUCCESS or FAILURE</span>\n    status\n    errors <span class="hljs-punctuation">{</span>\n      __typename\n      <span class="hljs-punctuation">...</span><span class="hljs-keyword">on</span> ErrorPayload <span class="hljs-punctuation">{</span>\n        message\n      <span class="hljs-punctuation">}</span>\n    <span class="hljs-punctuation">}</span>\n    post <span class="hljs-punctuation">{</span>\n      id\n      title\n      <span class="hljs-comment"># This is the status of the post: publish, pending, trash, etc</span>\n      status\n    <span class="hljs-punctuation">}</span>\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <p>The payload object allows us to represent better the errors, even having a unique GraphQL type per kind of error. This allows us to present different reactions for different errors in the application, thus improving the user experience.</p> <p>In the example above, the <code>PostUpdateMutationPayload</code> type contains field <code>errors</code>, which returns a list of <code>CustomPostUpdateMutationErrorPayloadUnion</code>. This is a union type which includes the list of all possible errors that can happen when modifying a custom post (to be queried via introspection field <code>__typename</code>):</p> <ul> <li><code>CustomPostDoesNotExistErrorPayload</code></li> <li><code>GenericErrorPayload</code></li> <li><code>LoggedInUserHasNoEditingCustomPostCapabilityErrorPayload</code></li> <li><code>LoggedInUserHasNoPermissionToEditCustomPostErrorPayload</code></li> <li><code>LoggedInUserHasNoPublishingCustomPostCapabilityErrorPayload</code></li> <li><code>UserIsNotLoggedInErrorPayload</code></li> </ul> <p>If the operation was successful, we will receive:</p> <pre><code class="hljs language-json"><span class="hljs"><span class="hljs-punctuation">{</span>\n  <span class="hljs-attr">&quot;data&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n    <span class="hljs-attr">&quot;updatePost&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n      <span class="hljs-attr">&quot;status&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;SUCCESS&quot;</span><span class="hljs-punctuation">,</span>\n      <span class="hljs-attr">&quot;errors&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-literal"><span class="hljs-keyword">null</span></span><span class="hljs-punctuation">,</span>\n      <span class="hljs-attr">&quot;post&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n        <span class="hljs-attr">&quot;id&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-number">1724</span><span class="hljs-punctuation">,</span>\n        <span class="hljs-attr">&quot;title&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;Some title&quot;</span><span class="hljs-punctuation">,</span>\n        <span class="hljs-attr">&quot;status&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;publish&quot;</span>\n      <span class="hljs-punctuation">}</span>\n    <span class="hljs-punctuation">}</span>\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <p>If the user is not logged in, we will receive:</p> <pre><code class="hljs language-json"><span class="hljs"><span class="hljs-punctuation">{</span>\n  <span class="hljs-attr">&quot;data&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n    <span class="hljs-attr">&quot;updatePost&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n      <span class="hljs-attr">&quot;status&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;FAILURE&quot;</span><span class="hljs-punctuation">,</span>\n      <span class="hljs-attr">&quot;errors&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">[</span>\n        <span class="hljs-punctuation">{</span>\n          <span class="hljs-attr">&quot;__typename&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;UserIsNotLoggedInErrorPayload&quot;</span><span class="hljs-punctuation">,</span>\n          <span class="hljs-attr">&quot;message&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;You must be logged in to create or update custom posts&quot;</span>\n        <span class="hljs-punctuation">}</span>\n      <span class="hljs-punctuation">]</span><span class="hljs-punctuation">,</span>\n      <span class="hljs-attr">&quot;post&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-literal"><span class="hljs-keyword">null</span></span>\n    <span class="hljs-punctuation">}</span>\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <p>If the user doesn&#39;t have the permission to edit posts, we will receive:</p> <pre><code class="hljs language-json"><span class="hljs"><span class="hljs-punctuation">{</span>\n  <span class="hljs-attr">&quot;data&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n    <span class="hljs-attr">&quot;updatePost&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n      <span class="hljs-attr">&quot;status&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;FAILURE&quot;</span><span class="hljs-punctuation">,</span>\n      <span class="hljs-attr">&quot;errors&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">[</span>\n        <span class="hljs-punctuation">{</span>\n          <span class="hljs-attr">&quot;__typename&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;LoggedInUserHasNoEditingCustomPostCapabilityErrorPayload&quot;</span><span class="hljs-punctuation">,</span>\n          <span class="hljs-attr">&quot;message&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;Your user doesn&#x27;t have permission for editing custom posts.&quot;</span>\n        <span class="hljs-punctuation">}</span>\n      <span class="hljs-punctuation">]</span><span class="hljs-punctuation">,</span>\n      <span class="hljs-attr">&quot;post&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-literal"><span class="hljs-keyword">null</span></span>\n    <span class="hljs-punctuation">}</span>\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <p>As a consequence of all the additional <code>MutationPayload</code>, <code>MutationErrorPayloadUnion</code> and <code>ErrorPayload</code> types added, the GraphQL schema will have a bigger size:</p> <div class="img-width-1024" markdown="1"> <p><img src="https://raw.githubusercontent.com/GatoGraphQL/GatoGraphQL/10.2.0/layers/GatoGraphQLForWP/plugins/gatographql/docs/modules/mutations/../../images/mutations-using-payload-object-types.webp" alt="GraphQL schema with payload object types for mutations" title="GraphQL schema with payload object types for mutations"></p> </div> <h4 id="query-the-mutation-payload-objects">Query the mutation payload objects</h4> <p>Every mutation in the schema has a corresponding field to query its recently-created payload objects, with name <code>{mutationName}MutationPayloadObjects</code>.</p> <p>These fields include:</p> <ul> <li><code>addCommentToCustomPostMutationPayloadObjects</code> (for <code>addCommentToCustomPost</code>)</li> <li><code>createCustomPostMutationPayloadObjects</code> (for <code>createCustomPost</code>)</li> <li><code>createMediaItemMutationPayloadObjects</code> (for <code>createMediaItem</code>)</li> <li><code>createPageMutationPayloadObjects</code> (for <code>createPage</code>)</li> <li><code>createPostMutationPayloadObjects</code> (for <code>createPost</code>)</li> <li><code>removeFeaturedImageFromCustomPostMutationPayloadObjects</code> (for <code>removeFeaturedImageFromCustomPost</code>)</li> <li><code>replyCommentMutationPayloadObjects</code> (for <code>replyComment</code>)</li> <li><code>setCategoriesOnPostMutationPayloadObjects</code> (for <code>setCategoriesOnPost</code>)</li> <li><code>setFeaturedImageOnCustomPostMutationPayloadObjects</code> (for <code>setFeaturedImageOnCustomPost</code>)</li> <li><code>setTagsOnPostMutationPayloadObjects</code> (for <code>setTagsOnPost</code>)</li> <li><code>updateCustomPostMutationPayloadObjects</code> (for <code>updateCustomPost</code>)</li> <li><code>updatePageMutationPayloadObjects</code> (for <code>updatePage</code>)</li> <li><code>updatePostMutationPayloadObjects</code> (for <code>updatePost</code>)</li> </ul> <p>These fields enable us to retrieve the results of mutations executed using <code>@applyField</code> while iterating the items in an array.</p> <p>For instance, the following query duplicates posts in bulk:</p> <pre><code class="hljs language-graphql"><span class="hljs"><span class="hljs-keyword">query</span> GetPostsAndExportData\n<span class="hljs-punctuation">{</span>\n  <span class="hljs-symbol">postsToDuplicate</span><span class="hljs-punctuation">:</span> posts <span class="hljs-punctuation">{</span>\n    title\n    rawContent\n    excerpt\n\n    <span class="hljs-comment"># Already create (and export) the inputs for the mutation</span>\n    <span class="hljs-symbol">postInput</span><span class="hljs-punctuation">:</span> _echo<span class="hljs-punctuation">(</span><span class="hljs-symbol">value</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n      <span class="hljs-symbol">title</span><span class="hljs-punctuation">:</span> <span class="hljs-variable">$__title</span>\n      <span class="hljs-symbol">contentAs</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n        <span class="hljs-symbol">html</span><span class="hljs-punctuation">:</span> <span class="hljs-variable">$__rawContent</span>\n      <span class="hljs-punctuation">}</span>,\n      <span class="hljs-symbol">excerpt</span><span class="hljs-punctuation">:</span> <span class="hljs-variable">$__excerpt</span>\n    <span class="hljs-punctuation">}</span><span class="hljs-punctuation">)</span>\n      <span class="hljs-meta">@export</span><span class="hljs-punctuation">(</span><span class="hljs-symbol">as</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;postInput&quot;</span>, <span class="hljs-symbol">type</span><span class="hljs-punctuation">:</span> LIST<span class="hljs-punctuation">)</span>\n      <span class="hljs-meta">@remove</span>\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span>\n\n<span class="hljs-keyword">mutation</span> CreatePosts\n  <span class="hljs-meta">@depends</span><span class="hljs-punctuation">(</span><span class="hljs-symbol">on</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;GetPostsAndExportData&quot;</span><span class="hljs-punctuation">)</span>\n<span class="hljs-punctuation">{</span>\n  <span class="hljs-symbol">createdPostMutationPayloadObjectIDs</span><span class="hljs-punctuation">:</span> _echo<span class="hljs-punctuation">(</span><span class="hljs-symbol">value</span><span class="hljs-punctuation">:</span> <span class="hljs-variable">$postInput</span>)\n    <span class="hljs-meta">@underEachArrayItem</span><span class="hljs-punctuation">(</span>\n      <span class="hljs-symbol">passValueOnwardsAs</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;input&quot;</span>\n    <span class="hljs-punctuation">)</span>\n      <span class="hljs-meta">@applyField</span><span class="hljs-punctuation">(</span>\n        <span class="hljs-symbol">name</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;createPost&quot;</span>\n        <span class="hljs-symbol">arguments</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n          <span class="hljs-symbol">input</span><span class="hljs-punctuation">:</span> <span class="hljs-variable">$input</span>\n        <span class="hljs-punctuation">}</span>,\n        <span class="hljs-symbol">setResultInResponse</span><span class="hljs-punctuation">:</span> <span class="hljs-literal">true</span>\n      <span class="hljs-punctuation">)</span>\n    <span class="hljs-meta">@export</span><span class="hljs-punctuation">(</span><span class="hljs-symbol">as</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;createdPostMutationPayloadObjectIDs&quot;</span><span class="hljs-punctuation">)</span>\n<span class="hljs-punctuation">}</span>\n\n<span class="hljs-keyword">query</span> DuplicatePosts\n  <span class="hljs-meta">@depends</span><span class="hljs-punctuation">(</span><span class="hljs-symbol">on</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;CreatePosts&quot;</span><span class="hljs-punctuation">)</span>\n<span class="hljs-punctuation">{</span>\n  <span class="hljs-symbol">createdPostMutationObjectPayloads</span><span class="hljs-punctuation">:</span> createPostMutationPayloadObjects<span class="hljs-punctuation">(</span><span class="hljs-symbol">input</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n    <span class="hljs-symbol">ids</span><span class="hljs-punctuation">:</span> <span class="hljs-variable">$createdPostMutationPayloadObjectIDs</span>\n  <span class="hljs-punctuation">}</span><span class="hljs-punctuation">)</span> <span class="hljs-punctuation">{</span>\n    status\n    errors <span class="hljs-punctuation">{</span>\n      __typename\n      <span class="hljs-punctuation">...</span><span class="hljs-keyword">on</span> ErrorPayload <span class="hljs-punctuation">{</span>\n        message\n      <span class="hljs-punctuation">}</span>\n    <span class="hljs-punctuation">}</span>\n    post <span class="hljs-punctuation">{</span>\n      id\n      title\n      rawContent\n      excerpt\n    <span class="hljs-punctuation">}</span>\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <p>By default, these fields are not added to the GraphQL schema. For that, we must select option &quot;Use payload types for mutations, and add fields to query those payload objects&quot; (see below).</p> <h3 id="mutated-entity">Mutated entity</h3> <p>The mutation will directly return the mutated entity in case of success, or <code>null</code> in case of failure, and any error message will be displayed in the JSON response&#39;s top-level <code>errors</code> entry.</p> <p>For instance, mutation <code>updatePost</code> will return the object of type <code>Post</code>:</p> <pre><code class="hljs language-graphql"><span class="hljs"><span class="hljs-keyword">mutation</span> UpdatePost <span class="hljs-punctuation">{</span>\n  updatePost<span class="hljs-punctuation">(</span><span class="hljs-symbol">input</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n    <span class="hljs-symbol">id</span><span class="hljs-punctuation">:</span> <span class="hljs-number">1724</span>,\n    <span class="hljs-symbol">title</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;New title&quot;</span>,\n    <span class="hljs-symbol">status</span><span class="hljs-punctuation">:</span> publish\n  <span class="hljs-punctuation">}</span><span class="hljs-punctuation">)</span> <span class="hljs-punctuation">{</span>\n    id\n    title\n    status\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <p>If the operation was successful, we will receive:</p> <pre><code class="hljs language-json"><span class="hljs"><span class="hljs-punctuation">{</span>\n  <span class="hljs-attr">&quot;data&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n    <span class="hljs-attr">&quot;updatePost&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n      <span class="hljs-attr">&quot;id&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-number">1724</span><span class="hljs-punctuation">,</span>\n      <span class="hljs-attr">&quot;title&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;Some title&quot;</span><span class="hljs-punctuation">,</span>\n      <span class="hljs-attr">&quot;status&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;publish&quot;</span>\n    <span class="hljs-punctuation">}</span>\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <p>In case of errors, these will appear under the <code>errors</code> entry of the response. For instance, if the user is not logged in, we will receive:</p> <pre><code class="hljs language-json"><span class="hljs"><span class="hljs-punctuation">{</span>\n    <span class="hljs-attr">&quot;errors&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">[</span>\n      <span class="hljs-punctuation">{</span>\n        <span class="hljs-attr">&quot;message&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;You must be logged in to create or update custom posts&#x27;&quot;</span><span class="hljs-punctuation">,</span>\n        <span class="hljs-attr">&quot;locations&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">[</span>\n          <span class="hljs-punctuation">{</span>\n            <span class="hljs-attr">&quot;line&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-number">2</span><span class="hljs-punctuation">,</span>\n            <span class="hljs-attr">&quot;column&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-number">3</span>\n          <span class="hljs-punctuation">}</span>\n        <span class="hljs-punctuation">]</span>\n      <span class="hljs-punctuation">}</span>\n  <span class="hljs-punctuation">]</span><span class="hljs-punctuation">,</span>\n  <span class="hljs-attr">&quot;data&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n    <span class="hljs-attr">&quot;updatePost&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-literal"><span class="hljs-keyword">null</span></span>\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <p>We must notice that, as a result, the top-level <code>errors</code> entry will contain not only syntax, schema validation and logic errors (eg: not passing a field argument&#39;s name, requesting a non-existing field, or calling <code>_sendHTTPRequest</code> and the network is down respectively), but also &quot;content validation&quot; errors (eg: &quot;you&#39;re not authorized to modify this post&quot;).</p> <p>Because there are no additional types added, the GraphQL schema will look leaner:</p> <div class="img-width-1024" markdown="1"> <p><img src="https://raw.githubusercontent.com/GatoGraphQL/GatoGraphQL/10.2.0/layers/GatoGraphQLForWP/plugins/gatographql/docs/modules/mutations/../../images/mutations-not-using-payload-object-types.webp" alt="GraphQL schema without payload object types for mutations" title="GraphQL schema without payload object types for mutations"></p> </div> <h3 id="configuration">Configuration</h3> <p>We can configure the GraphQL schema with one among three options:</p> <ul> <li>Use payload types for mutations</li> <li>Use payload types for mutations, and add fields to query those payload objects</li> <li>Do not use payload types for mutations (i.e. return the mutated entity)</li> </ul> <p>Using payload object types for mutations in the schema can be configured as follows, in order of priority:</p> <p>✅ Specific mode for the custom endpoint or persisted query, defined in the schema configuration</p> <p><img src="https://raw.githubusercontent.com/GatoGraphQL/GatoGraphQL/10.2.0/layers/GatoGraphQLForWP/plugins/gatographql/docs/modules/mutations/../../images/schema-configuration-payload-object-types-for-mutations.webp" alt="Defining if and how to use payload object types for mutations, set in the Schema configuration" title="Defining if and how to use payload object types for mutations, set in the Schema configuration"></p> <p>✅ Default mode, defined in the Settings</p> <p>If the schema configuration has value <code>&quot;Default&quot;</code>, it will use the mode defined in the Settings:</p> <div class="img-width-1024" markdown="1"> <p><img src="https://raw.githubusercontent.com/GatoGraphQL/GatoGraphQL/10.2.0/layers/GatoGraphQLForWP/plugins/gatographql/docs/modules/mutations/../../images/settings-payload-object-types-for-mutations-default.webp" alt="Defining if and how to use payload object types for mutations, in the Settings" title="Defining if and how to use payload object types for mutations, in the Settings"></p> </div> '}}]);