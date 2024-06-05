(window.webpackJsonpGatoGraphQLSchemaConfigSelfFields=window.webpackJsonpGatoGraphQLSchemaConfigSelfFields||[]).push([[1],{50:function(s,a){s.exports='<h1 id="self-fields">Self Fields</h1> <p>Expose &quot;self&quot; fields in the GraphQL schema, which can help give a particular shape to the GraphQL response.</p> <h2 id="description">Description</h2> <p>Sometimes we need to modify the shape of the response, to emulate the same response from another GraphQL server, or from the REST API.</p> <p>We can do this via the <code>self</code> field, added to all types in the GraphQL schema, which echoes back the same object where it is applied:</p> <pre><code class="hljs language-graphql"><span class="hljs"><span class="hljs-keyword">type</span> QueryRoot <span class="hljs-punctuation">{</span>\n  <span class="hljs-symbol">self</span><span class="hljs-punctuation">:</span> QueryRoot<span class="hljs-punctuation">!</span>\n<span class="hljs-punctuation">}</span>\n\n<span class="hljs-keyword">type</span> Post <span class="hljs-punctuation">{</span>\n  <span class="hljs-symbol">self</span><span class="hljs-punctuation">:</span> Post<span class="hljs-punctuation">!</span>\n<span class="hljs-punctuation">}</span>\n\n<span class="hljs-keyword">type</span> User <span class="hljs-punctuation">{</span>\n  <span class="hljs-symbol">self</span><span class="hljs-punctuation">:</span> User<span class="hljs-punctuation">!</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <p>The <code>self</code> field allows to append extra levels to the query without leaving the queried object. Running this query:</p> <pre><code class="hljs language-graphql"><span class="hljs"><span class="hljs-punctuation">{</span>\n  __typename\n  self <span class="hljs-punctuation">{</span>\n    __typename\n  <span class="hljs-punctuation">}</span>\n\n  post<span class="hljs-punctuation">(</span><span class="hljs-symbol">by</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span> <span class="hljs-symbol">id</span><span class="hljs-punctuation">:</span> <span class="hljs-number">1</span> <span class="hljs-punctuation">}</span><span class="hljs-punctuation">)</span> <span class="hljs-punctuation">{</span>\n    self <span class="hljs-punctuation">{</span>\n      id\n      __typename\n    <span class="hljs-punctuation">}</span>\n  <span class="hljs-punctuation">}</span>\n\n  user<span class="hljs-punctuation">(</span><span class="hljs-symbol">by</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span> <span class="hljs-symbol">id</span><span class="hljs-punctuation">:</span> <span class="hljs-number">1</span> <span class="hljs-punctuation">}</span><span class="hljs-punctuation">)</span> <span class="hljs-punctuation">{</span>\n    self <span class="hljs-punctuation">{</span>\n      id\n      __typename\n    <span class="hljs-punctuation">}</span>\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <p>...produces this response:</p> <pre><code class="hljs language-json"><span class="hljs"><span class="hljs-punctuation">{</span>\n  <span class="hljs-attr">&quot;data&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n    <span class="hljs-attr">&quot;__typename&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;QueryRoot&quot;</span><span class="hljs-punctuation">,</span>\n    <span class="hljs-attr">&quot;self&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n      <span class="hljs-attr">&quot;__typename&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;QueryRoot&quot;</span>\n    <span class="hljs-punctuation">}</span><span class="hljs-punctuation">,</span>\n    <span class="hljs-attr">&quot;post&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n      <span class="hljs-attr">&quot;self&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n        <span class="hljs-attr">&quot;id&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-number">1</span><span class="hljs-punctuation">,</span>\n        <span class="hljs-attr">&quot;__typename&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;Post&quot;</span>\n      <span class="hljs-punctuation">}</span>\n    <span class="hljs-punctuation">}</span><span class="hljs-punctuation">,</span>\n    <span class="hljs-attr">&quot;user&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n      <span class="hljs-attr">&quot;self&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n        <span class="hljs-attr">&quot;id&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-number">1</span><span class="hljs-punctuation">,</span>\n        <span class="hljs-attr">&quot;__typename&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;User&quot;</span>\n      <span class="hljs-punctuation">}</span>\n    <span class="hljs-punctuation">}</span>\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <h2 id="examples">Examples</h2> <p>This query uses <code>self</code> to artificially append the extra levels needed for the response, and field aliases to rename those levels appropriately, as to recreate the shape of another GraphQL server:</p> <pre><code class="hljs language-graphql"><span class="hljs"><span class="hljs-punctuation">{</span>\n  <span class="hljs-symbol">categories</span><span class="hljs-punctuation">:</span> self <span class="hljs-punctuation">{</span>\n    <span class="hljs-symbol">edges</span><span class="hljs-punctuation">:</span> postCategories <span class="hljs-punctuation">{</span>\n      <span class="hljs-symbol">node</span><span class="hljs-punctuation">:</span> self <span class="hljs-punctuation">{</span>\n        name\n        slug\n      <span class="hljs-punctuation">}</span>\n    <span class="hljs-punctuation">}</span>\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <p>This query recreates the shape of the WP REST API:</p> <pre><code class="hljs language-graphql"><span class="hljs"><span class="hljs-punctuation">{</span>\n  post<span class="hljs-punctuation">(</span><span class="hljs-symbol">by</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span><span class="hljs-symbol">id</span><span class="hljs-punctuation">:</span> <span class="hljs-number">1</span><span class="hljs-punctuation">}</span><span class="hljs-punctuation">)</span> <span class="hljs-punctuation">{</span>\n    <span class="hljs-symbol">content</span><span class="hljs-punctuation">:</span> self <span class="hljs-punctuation">{</span>\n      <span class="hljs-symbol">rendered</span><span class="hljs-punctuation">:</span> content\n    <span class="hljs-punctuation">}</span>\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <h2 id="how-to-use">How to use</h2> <p>Exposing &quot;self&quot; fields in the schema can be configured as follows, in order of priority:</p> <p>✅ Specific mode for the custom endpoint or persisted query, defined in the schema configuration</p> <p><img src="https://raw.githubusercontent.com/GatoGraphQL/GatoGraphQL/2.5.1/layers/GatoGraphQLForWP/plugins/gatographql/docs/modules/schema-self-fields/../../images/schema-configuration-adding-self-fields-to-schema.png" alt="Adding self fields to the schema, set in the Schema configuration" title="Adding self fields to the schema, set in the Schema configuration"></p> <p>✅ Default mode, defined in the Settings</p> <p>If the schema configuration has value <code>&quot;Default&quot;</code>, it will use the mode defined in the Settings:</p> <div class="img-width-1024" markdown="1"> <p><img src="https://raw.githubusercontent.com/GatoGraphQL/GatoGraphQL/2.5.1/layers/GatoGraphQLForWP/plugins/gatographql/docs/modules/schema-self-fields/../../images/settings-self-fields-default.png" alt="Expose self fields in the schema, in the Settings" title="Expose self fields in the schema, in the Settings"></p> </div> '}}]);