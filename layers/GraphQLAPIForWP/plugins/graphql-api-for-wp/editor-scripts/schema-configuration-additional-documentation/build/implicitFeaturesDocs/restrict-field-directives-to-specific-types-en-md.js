(window.webpackJsonpGraphQLAPISchemaConfigurationAdditionalDocumentation=window.webpackJsonpGraphQLAPISchemaConfigurationAdditionalDocumentation||[]).push([[4],{49:function(s,n){s.exports='<h1 id="restrict-field-directives-to-specific-types">Restrict Field Directives to Specific Types</h1> <p>Field Directives can be restricted to be applied on fields of some specific type only.</p> <h2 id="description">Description</h2> <p>GraphQL enables to apply directives to fields, to modify their value. For instance, field directive <code>@strUpperCase</code> transforms the string in the field to upper case:</p> <pre><code class="hljs language-graphql"><span class="hljs"><span class="hljs-punctuation">{</span>\n  posts <span class="hljs-punctuation">{</span>\n    title <span class="hljs-meta">@strUpperCase</span>\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <p>...producing:</p> <pre><code class="hljs language-json"><span class="hljs"><span class="hljs-punctuation">{</span>\n  <span class="hljs-attr">&quot;data&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n    <span class="hljs-attr">&quot;posts&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">[</span>\n      <span class="hljs-punctuation">{</span>\n        <span class="hljs-attr">&quot;title&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;HELLO WORLD!&quot;</span>\n      <span class="hljs-punctuation">}</span>\n    <span class="hljs-punctuation">]</span>\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <p>The functionality for <code>@strUpperCase</code> makes sense when applied on a <code>String</code> (as in the field <code>Post.title</code> above), but not on other types, such as <code>Int</code>, <code>Bool</code>, <code>Float</code> or any custom scalar type.</p> <p>The <strong>Restrict Field Directives to Specific Types</strong> feature solves this problem, by having a field directive define what types it supports.</p> <p>Field directive <code>@strUpperCase</code> has defined to support the following types only:</p> <ul> <li><code>String</code></li> <li><code>ID</code></li> <li><code>AnyBuiltInScalar</code></li> </ul> <p>When the type is <code>String</code>, the validation succeeds automatically. When the type is <code>ID</code> or <code>AnyBuiltInScalar</code>, an extra validation <code>is_string</code> is performed on the value before it is accepted. For any other type, the validation fails, and an error message is returned.</p> <p>The query below will then not work, as field <code>Post.commentCount</code> has type <code>Int</code>, which cannot be converted to upper case:</p> <pre><code class="hljs language-graphql"><span class="hljs"><span class="hljs-punctuation">{</span>\n  posts <span class="hljs-punctuation">{</span>\n    commentCount <span class="hljs-meta">@strUpperCase</span>\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <p>...producing this response:</p> <pre><code class="hljs language-json"><span class="hljs"><span class="hljs-punctuation">{</span>\n  <span class="hljs-attr">&quot;errors&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">[</span>\n    <span class="hljs-punctuation">{</span>\n      <span class="hljs-attr">&quot;message&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;Directive &#x27;strUpperCase&#x27; is not supported at this directive location, or for this node in the GraphQL query&quot;</span><span class="hljs-punctuation">,</span>\n      <span class="hljs-attr">&quot;locations&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">[</span>\n        <span class="hljs-punctuation">{</span>\n          <span class="hljs-attr">&quot;line&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-number">3</span><span class="hljs-punctuation">,</span>\n          <span class="hljs-attr">&quot;column&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-number">19</span>\n        <span class="hljs-punctuation">}</span>\n      <span class="hljs-punctuation">]</span><span class="hljs-punctuation">,</span>\n      <span class="hljs-attr">&quot;extensions&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n        <span class="hljs-attr">&quot;path&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">[</span>\n          <span class="hljs-string">&quot;@strUpperCase&quot;</span><span class="hljs-punctuation">,</span>\n          <span class="hljs-string">&quot;commentCount @strUpperCase&quot;</span><span class="hljs-punctuation">,</span>\n          <span class="hljs-string">&quot;posts { ... }&quot;</span><span class="hljs-punctuation">,</span>\n          <span class="hljs-string">&quot;query { ... }&quot;</span>\n        <span class="hljs-punctuation">]</span><span class="hljs-punctuation">,</span>\n        <span class="hljs-attr">&quot;type&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;Post&quot;</span><span class="hljs-punctuation">,</span>\n        <span class="hljs-attr">&quot;field&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;commentCount @strUpperCase&quot;</span><span class="hljs-punctuation">,</span>\n        <span class="hljs-attr">&quot;code&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;gql@5.7.2&quot;</span><span class="hljs-punctuation">,</span>\n        <span class="hljs-attr">&quot;specifiedBy&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;https://spec.graphql.org/draft/#sec-Directives-Are-In-Valid-Locations&quot;</span>\n      <span class="hljs-punctuation">}</span>\n    <span class="hljs-punctuation">}</span>\n  <span class="hljs-punctuation">]</span><span class="hljs-punctuation">,</span>\n  <span class="hljs-attr">&quot;data&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n    <span class="hljs-attr">&quot;posts&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">[</span>\n      <span class="hljs-punctuation">{</span>\n        <span class="hljs-attr">&quot;commentCount&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-literal"><span class="hljs-keyword">null</span></span>\n      <span class="hljs-punctuation">}</span>\n    <span class="hljs-punctuation">]</span>\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <h2 id="naming-convention">Naming Convention</h2> <p>Whenever a field directive is restricted to some type, the type identifier (<code>String</code> =&gt; <code>str</code>, <code>Int</code> =&gt; <code>int</code>, <code>Boolean</code> =&gt; <code>bool</code>, etc) is added at the beginning of the directive name. In addition, the type modifier of &quot;Array&quot; (such as <code>[String]</code>) can also be added to the name:</p> <ul> <li>No restrictions: <code>@default</code></li> <li>Arrays: <code>@arrayUnique</code></li> <li><code>Boolean</code>: <code>@boolOpposite</code></li> <li><code>Int</code>: <code>@intAdd</code></li> <li><code>JSONObject</code>: <code>@objectAddEntry</code></li> <li><code>String</code>: <code>@strSubstr</code></li> </ul> <h2 id="introspection">Introspection</h2> <p>To find out which are the supported types for each field directive, custom directive extension <code>fieldDirectiveSupportedTypeNamesOrDescriptions</code> is available via introspection:</p> <pre><code class="hljs language-graphql"><span class="hljs"><span class="hljs-keyword">query</span> IntrospectionDirectiveExtensions <span class="hljs-punctuation">{</span>\n  __schema <span class="hljs-punctuation">{</span>\n    directives <span class="hljs-punctuation">{</span>\n      name\n      extensions <span class="hljs-punctuation">{</span>\n        fieldDirectiveSupportedTypeNamesOrDescriptions\n      <span class="hljs-punctuation">}</span>\n    <span class="hljs-punctuation">}</span>\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <p>The response of <code>fieldDirectiveSupportedTypeNamesOrDescriptions</code> will be the names or descriptions of the types the field directives is restricted to, or <code>null</code> if it supports any type (i.e. it defines no restrictions).</p> <p>For other directives, such as Operation Directives, it will always return <code>null</code>.</p> <p>For instance, running the query above will produce:</p> <pre><code class="hljs language-json"><span class="hljs"><span class="hljs-punctuation">{</span>\n  <span class="hljs-attr">&quot;data&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n    <span class="hljs-attr">&quot;__schema&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n      <span class="hljs-attr">&quot;directives&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">[</span>\n        <span class="hljs-punctuation">{</span>\n          <span class="hljs-attr">&quot;name&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;applyField&quot;</span><span class="hljs-punctuation">,</span>\n          <span class="hljs-attr">&quot;extensions&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n            <span class="hljs-attr">&quot;fieldDirectiveSupportedTypeNamesOrDescriptions&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-literal"><span class="hljs-keyword">null</span></span>\n          <span class="hljs-punctuation">}</span>\n        <span class="hljs-punctuation">}</span><span class="hljs-punctuation">,</span>\n        <span class="hljs-punctuation">{</span>\n          <span class="hljs-attr">&quot;name&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;arrayUnique&quot;</span><span class="hljs-punctuation">,</span>\n          <span class="hljs-attr">&quot;extensions&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n            <span class="hljs-attr">&quot;fieldDirectiveSupportedTypeNamesOrDescriptions&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-literal"><span class="hljs-keyword">null</span></span>\n          <span class="hljs-punctuation">}</span>\n        <span class="hljs-punctuation">}</span><span class="hljs-punctuation">,</span>\n        <span class="hljs-punctuation">{</span>\n          <span class="hljs-attr">&quot;name&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;boolOpposite&quot;</span><span class="hljs-punctuation">,</span>\n          <span class="hljs-attr">&quot;extensions&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n            <span class="hljs-attr">&quot;fieldDirectiveSupportedTypeNamesOrDescriptions&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">[</span>\n              <span class="hljs-string">&quot;Boolean&quot;</span><span class="hljs-punctuation">,</span>\n              <span class="hljs-string">&quot;AnyBuiltInScalar&quot;</span>\n            <span class="hljs-punctuation">]</span>\n          <span class="hljs-punctuation">}</span>\n        <span class="hljs-punctuation">}</span><span class="hljs-punctuation">,</span>\n        <span class="hljs-punctuation">{</span>\n          <span class="hljs-attr">&quot;name&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;default&quot;</span><span class="hljs-punctuation">,</span>\n          <span class="hljs-attr">&quot;extensions&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n            <span class="hljs-attr">&quot;fieldDirectiveSupportedTypeNamesOrDescriptions&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">[</span>\n              <span class="hljs-string">&quot;String&quot;</span><span class="hljs-punctuation">,</span>\n              <span class="hljs-string">&quot;Float&quot;</span><span class="hljs-punctuation">,</span>\n              <span class="hljs-string">&quot;Int&quot;</span><span class="hljs-punctuation">,</span>\n              <span class="hljs-string">&quot;Boolean&quot;</span><span class="hljs-punctuation">,</span>\n              <span class="hljs-string">&quot;ID&quot;</span><span class="hljs-punctuation">,</span>\n              <span class="hljs-string">&quot;AnyBuiltInScalar&quot;</span><span class="hljs-punctuation">,</span>\n              <span class="hljs-string">&quot;Relational fields (eg: `{ comments { authorOrDefaultAuthor: author @default(value: 1) { id name } } }`)&quot;</span>\n            <span class="hljs-punctuation">]</span>\n          <span class="hljs-punctuation">}</span>\n        <span class="hljs-punctuation">}</span><span class="hljs-punctuation">,</span>\n        <span class="hljs-punctuation">{</span>\n          <span class="hljs-attr">&quot;name&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;depends&quot;</span><span class="hljs-punctuation">,</span>\n          <span class="hljs-attr">&quot;extensions&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n            <span class="hljs-attr">&quot;fieldDirectiveSupportedTypeNamesOrDescriptions&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-literal"><span class="hljs-keyword">null</span></span>\n          <span class="hljs-punctuation">}</span>\n        <span class="hljs-punctuation">}</span><span class="hljs-punctuation">,</span>\n        <span class="hljs-punctuation">{</span>\n          <span class="hljs-attr">&quot;name&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;intAdd&quot;</span><span class="hljs-punctuation">,</span>\n          <span class="hljs-attr">&quot;extensions&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n            <span class="hljs-attr">&quot;fieldDirectiveSupportedTypeNamesOrDescriptions&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">[</span>\n              <span class="hljs-string">&quot;Int&quot;</span><span class="hljs-punctuation">,</span>\n              <span class="hljs-string">&quot;Numeric&quot;</span><span class="hljs-punctuation">,</span>\n              <span class="hljs-string">&quot;AnyBuiltInScalar&quot;</span>\n            <span class="hljs-punctuation">]</span>\n          <span class="hljs-punctuation">}</span>\n        <span class="hljs-punctuation">}</span><span class="hljs-punctuation">,</span>\n        <span class="hljs-punctuation">{</span>\n          <span class="hljs-attr">&quot;name&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;objectAddEntry&quot;</span><span class="hljs-punctuation">,</span>\n          <span class="hljs-attr">&quot;extensions&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n            <span class="hljs-attr">&quot;fieldDirectiveSupportedTypeNamesOrDescriptions&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">[</span>\n              <span class="hljs-string">&quot;JSONObject&quot;</span>\n            <span class="hljs-punctuation">]</span>\n          <span class="hljs-punctuation">}</span>\n        <span class="hljs-punctuation">}</span><span class="hljs-punctuation">,</span>\n        <span class="hljs-punctuation">{</span>\n          <span class="hljs-attr">&quot;name&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;strSubstr&quot;</span><span class="hljs-punctuation">,</span>\n          <span class="hljs-attr">&quot;extensions&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">{</span>\n            <span class="hljs-attr">&quot;fieldDirectiveSupportedTypeNamesOrDescriptions&quot;</span><span class="hljs-punctuation">:</span> <span class="hljs-punctuation">[</span>\n              <span class="hljs-string">&quot;String&quot;</span><span class="hljs-punctuation">,</span>\n              <span class="hljs-string">&quot;ID&quot;</span><span class="hljs-punctuation">,</span>\n              <span class="hljs-string">&quot;AnyBuiltInScalar&quot;</span>\n            <span class="hljs-punctuation">]</span>\n          <span class="hljs-punctuation">}</span>\n        <span class="hljs-punctuation">}</span>\n      <span class="hljs-punctuation">]</span>\n    <span class="hljs-punctuation">}</span>\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <p>Please notice that the data includes not only type names, but also descriptions, which is useful to denote a category of types.</p> <p>For instance, directive <code>@default</code> also supports any relational field, like this:</p> <pre><code class="hljs language-graphql"><span class="hljs"><span class="hljs-punctuation">{</span>\n  comments <span class="hljs-punctuation">{</span>\n    <span class="hljs-symbol">authorOrDefaultAuthor</span><span class="hljs-punctuation">:</span> author <span class="hljs-meta">@default</span><span class="hljs-punctuation">(</span><span class="hljs-symbol">value</span><span class="hljs-punctuation">:</span> <span class="hljs-number">1</span><span class="hljs-punctuation">)</span> <span class="hljs-punctuation">{</span>\n      id\n      name\n    <span class="hljs-punctuation">}</span>\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <p>Instead of stating every single type (<code>Post</code>, <code>User</code>, <code>Comment</code>, etc), the description <code>&quot;Relational fields&quot;</code> already represents all of them.</p> '}}]);