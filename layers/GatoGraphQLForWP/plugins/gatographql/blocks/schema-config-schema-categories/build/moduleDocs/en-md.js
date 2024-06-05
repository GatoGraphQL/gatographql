(window.webpackJsonpGatographqlSchemaConfigSchemaCategories=window.webpackJsonpGatographqlSchemaConfigSchemaCategories||[]).push([[1],{50:function(s,a){s.exports='<h1 id="categories">Categories</h1> <p>Query post categories and custom categories</p> <h2 id="description">Description</h2> <p>We can add categories to posts in WordPress (i.e. using the taxonomy with name <code>&quot;category&quot;</code>). This is already mapped in the GraphQL schema via the <code>PostCategory</code>, associated to a <code>Post</code> entry.</p> <p>Custom Post Types defined by any theme or plugin (such as <code>&quot;product&quot;</code>) can likewise have their own category taxonomy associated to them (such as <code>&quot;product-cat&quot;</code>). As these category taxonomies don&#39;t ship their own specific type for the GraphQL schema (that would require an extension via PHP code), these are resolved via the <code>GenericCategory</code> type.</p> <p>We use fields <code>category</code> and <code>categories</code> to fetch category data, which must indicate which taxonomy they refer to via mandatory field argument <code>taxonomy</code>. The result is of the union type <code>CategoryUnion</code>, which includes entries from either <code>PostCategory</code> or <code>GenericCategory</code> (depending on the entry&#39;s taxonomy).</p> <p><img src="https://raw.githubusercontent.com/GatoGraphQL/GatoGraphQL/2.5.1/layers/GatoGraphQLForWP/plugins/gatographql/docs/modules/schema-categories/../../images/interactive-schema-category-union.png" alt="CategoryUnion type in the Interactive Schema" title="CategoryUnion type in the Interactive Schema"></p> <h2 id="querying-categories">Querying categories</h2> <p>This query retrieves categories with taxonomy <code>&quot;product-category&quot;</code>:</p> <pre><code class="hljs language-graphql"><span class="hljs"><span class="hljs-punctuation">{</span>\n  categories<span class="hljs-punctuation">(</span><span class="hljs-symbol">taxonomy</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;product-category&quot;</span><span class="hljs-punctuation">)</span> <span class="hljs-punctuation">{</span>\n    __typename\n\n    <span class="hljs-punctuation">...</span><span class="hljs-keyword">on</span> Category <span class="hljs-punctuation">{</span>\n      count\n      description\n      id\n      name\n      slug\n      url\n    <span class="hljs-punctuation">}</span>\n\n    <span class="hljs-punctuation">...</span><span class="hljs-keyword">on</span> GenericCategory <span class="hljs-punctuation">{</span>\n      taxonomy   \n      customPostCount\n      customPosts <span class="hljs-punctuation">{</span>\n        __typename\n        <span class="hljs-punctuation">...</span><span class="hljs-keyword">on</span> CustomPost <span class="hljs-punctuation">{</span>\n          id\n          title\n        <span class="hljs-punctuation">}</span>\n      <span class="hljs-punctuation">}</span>\n    <span class="hljs-punctuation">}</span>\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <p>Type <code>GenericCustomPost</code> has field <code>categories</code>, to retrieve the custom categories added to the custom post:</p> <pre><code class="hljs language-graphql"><span class="hljs"><span class="hljs-punctuation">{</span>\n  customPosts<span class="hljs-punctuation">(</span>\n    <span class="hljs-symbol">filter</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span> <span class="hljs-symbol">customPostTypes</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;product&quot;</span> <span class="hljs-punctuation">}</span>\n  <span class="hljs-punctuation">)</span> <span class="hljs-punctuation">{</span>\n    __typename\n\n    <span class="hljs-punctuation">...</span> <span class="hljs-keyword">on</span> GenericCustomPost <span class="hljs-punctuation">{</span>\n      categories<span class="hljs-punctuation">(</span><span class="hljs-symbol">taxonomy</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;product-cat&quot;</span><span class="hljs-punctuation">)</span> <span class="hljs-punctuation">{</span>\n        __typename\n        id\n        name\n        taxonomy\n      <span class="hljs-punctuation">}</span>\n    <span class="hljs-punctuation">}</span>\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <h2 id="defining-the-allowed-category-taxonomies">Defining the allowed Category Taxonomies</h2> <p>The category taxonomies that can be queried must be explicitly configured. This can be done in 2 places.</p> <p>In the Schema Configuration applied to the endpoint, by selecting option <code>&quot;Use custom configuration&quot;</code> under &quot;Customize configuration? (Or use default from Settings?)&quot; and then selecting the desired items:</p> <p><img src="https://raw.githubusercontent.com/GatoGraphQL/GatoGraphQL/2.5.1/layers/GatoGraphQLForWP/plugins/gatographql/docs/modules/schema-categories/../../images/categories-schema-configuration-queryable-taxonomies.png" alt="Selecting the allowed category taxonomies in the Schema Configuration" title="Selecting the allowed category taxonomies in the Schema Configuration"></p> <p><em>This list contains all the &quot;hierarchical&quot; taxonomies which are associated to queryable custom posts, i.e. those selected in &quot;Included custom post types&quot; in the Settings for &quot;Custom Posts&quot;. If your desired category taxonomy does not appear here, make sure that all of its associated custom post types are in that allowlist.</em></p> <p>Otherwise, the value defined under section &quot;Included category taxonomies&quot; in the Settings page for <code>Schema Custom Posts</code> is used:</p> <div class="img-width-1024" markdown="1"> <p><img src="https://raw.githubusercontent.com/GatoGraphQL/GatoGraphQL/2.5.1/layers/GatoGraphQLForWP/plugins/gatographql/docs/modules/schema-categories/../../images/categories-settings-queryable-taxonomies.png" alt="Selecting the allowed category taxonomies in the Settings" title="Selecting the allowed category taxonomies in the Settings"></p> </div> <h2 id="additional-configuration">Additional configuration</h2> <p>Through the Settings for <code>Schema Categories</code>, we can also define:</p> <ul> <li>The default number of elements to retrieve (i.e. when field argument <code>limit</code> is not set) when querying for a list of any category taxonomy</li> <li>The maximum number of elements that can be retrieved in a single query execution</li> </ul> <div class="img-width-1024" markdown="1"> <p><img src="https://raw.githubusercontent.com/GatoGraphQL/GatoGraphQL/2.5.1/layers/GatoGraphQLForWP/plugins/gatographql/docs/modules/schema-categories/../../images/settings-categories-limits.png" alt="Settings for Category limits" title="Settings for Category limits"></p> </div> '}}]);