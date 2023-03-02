(window.webpackJsonpGraphQLAPISchemaConfigurationAdditionalDocumentationPRO=window.webpackJsonpGraphQLAPISchemaConfigurationAdditionalDocumentationPRO||[]).push([[7],{52:function(s,a){s.exports='<h1 id="cache-directive">Cache Directive</h1> <p>The <code>@cache</code> directive stores the result from a field in disk for a requested amount of time. When executing the same field within that time span, the cached value is returned</p> <h2 id="description">Description</h2> <p>Add <code>@cache</code> to the field to cache, specifying for how long (in seconds) under argument <code>time</code>.</p> <p>In this example, the Google-Translated <code>title</code> field is cached for 10 seconds. Executing the query twice within this time span will have the second call execute very fast.</p> <pre><code class="hljs language-graphql"><span class="hljs"><span class="hljs-keyword">query</span> <span class="hljs-punctuation">{</span>\n  posts<span class="hljs-punctuation">(</span><span class="hljs-symbol">pagination</span><span class="hljs-punctuation">:</span><span class="hljs-punctuation">{</span> <span class="hljs-symbol">limit</span><span class="hljs-punctuation">:</span> <span class="hljs-number">3</span> <span class="hljs-punctuation">}</span><span class="hljs-punctuation">)</span> <span class="hljs-punctuation">{</span>\n    id\n    title\n      <span class="hljs-meta">@strTranslate</span><span class="hljs-punctuation">(</span><span class="hljs-symbol">from</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;en&quot;</span>, <span class="hljs-symbol">to</span><span class="hljs-punctuation">:</span> <span class="hljs-string">&quot;es&quot;</span><span class="hljs-punctuation">)</span>\n      <span class="hljs-meta">@cache</span><span class="hljs-punctuation">(</span><span class="hljs-symbol">time</span><span class="hljs-punctuation">:</span> <span class="hljs-number">10</span><span class="hljs-punctuation">)</span>\n  <span class="hljs-punctuation">}</span>\n<span class="hljs-punctuation">}</span></span></code></pre> <h2 id="when-to-use">When to use</h2> <p>This directive is useful to avoid the execution of expensive operations, such as when interacting with external APIs.</p> '}}]);