(window.webpackJsonpGraphQLAPICustomEndpointProperties=window.webpackJsonpGraphQLAPICustomEndpointProperties||[]).push([[1],{8:function(e,t,n){}}]),function(e){function t(t){for(var r,i,o=t[0],s=t[1],c=t[2],u=0,m=[];u<o.length;u++)i=o[u],Object.prototype.hasOwnProperty.call(l,i)&&l[i]&&m.push(l[i][0]),l[i]=0;for(r in s)Object.prototype.hasOwnProperty.call(s,r)&&(e[r]=s[r]);for(p&&p(t);m.length;)m.shift()();return a.push.apply(a,c||[]),n()}function n(){for(var e,t=0;t<a.length;t++){for(var n=a[t],r=!0,o=1;o<n.length;o++){var s=n[o];0!==l[s]&&(r=!1)}r&&(a.splice(t--,1),e=i(i.s=n[0]))}return e}var r={},l={0:0},a=[];function i(t){if(r[t])return r[t].exports;var n=r[t]={i:t,l:!1,exports:{}};return e[t].call(n.exports,n,n.exports,i),n.l=!0,n.exports}i.m=e,i.c=r,i.d=function(e,t,n){i.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},i.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},i.t=function(e,t){if(1&t&&(e=i(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var n=Object.create(null);if(i.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var r in e)i.d(n,r,function(t){return e[t]}.bind(null,r));return n},i.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return i.d(t,"a",t),t},i.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},i.p="";var o=window.webpackJsonpGraphQLAPICustomEndpointProperties=window.webpackJsonpGraphQLAPICustomEndpointProperties||[],s=o.push.bind(o);o.push=t,o=o.slice();for(var c=0;c<o.length;c++)t(o[c]);var p=s;a.push([9,1]),n()}([function(e,t){e.exports=window.wp.element},function(e,t){e.exports=window.wp.i18n},function(e,t){e.exports=window.wp.components},function(e,t){e.exports=window.wp.editor},function(e,t){e.exports=window.wp.plugins},function(e,t){e.exports=window.wp.editPost},function(e,t){e.exports=window.wp.data},function(e,t){e.exports=window.wp.url},,function(e,t,n){"use strict";n.r(t);var r=n(4),l=n(0),a=n(1),i=n(5),o=n(6),s=n(7),c=n(2),p=n(3);function u(){var e=Object(o.useSelect)((function(e){var t=e(p.store).getCurrentPost(),n=e(p.store).getPermalinkParts(),r=e(p.store).getBlocks(),l=r.filter((function(e){return"graphql-api/custom-endpoint-options"===e.name})).shift(),a=r.filter((function(e){return"graphql-api/endpoint-graphiql"===e.name})).shift(),i=r.filter((function(e){return"graphql-api/endpoint-voyager"===e.name})).shift();return{postSlug:Object(s.safeDecodeURIComponent)(e(p.store).getEditedPostSlug()),postLink:t.link,permalinkPrefix:null==n?void 0:n.prefix,permalinkSuffix:null==n?void 0:n.suffix,isCustomEndpointEnabled:l.attributes.isEnabled,isGraphiQLClientEnabled:a.attributes.isEnabled,isVoyagerClientEnabled:i.attributes.isEnabled}}),[]),t=e.postSlug,n=e.postLink,r=e.permalinkPrefix,i=e.permalinkSuffix,u=e.isCustomEndpointEnabled,m=e.isGraphiQLClientEnabled,d=e.isVoyagerClientEnabled;return Object(l.createElement)(l.Fragment,null,u&&Object(l.createElement)(l.Fragment,null,Object(l.createElement)("div",{className:"editor-post-url"},Object(l.createElement)("h3",{className:"editor-post-url__link-label"},"🟢 ",Object(a.__)("Custom Endpoint URL")),Object(l.createElement)("p",null,Object(l.createElement)(c.ExternalLink,{className:"editor-post-url__link",href:n,target:"_blank"},Object(l.createElement)(l.Fragment,null,Object(l.createElement)("span",{className:"editor-post-url__link-prefix"},r),Object(l.createElement)("span",{className:"editor-post-url__link-slug"},t),Object(l.createElement)("span",{className:"editor-post-url__link-suffix"},i))))),Object(l.createElement)("hr",null)),Object(l.createElement)("div",{className:"editor-post-url"},Object(l.createElement)("h3",{className:"editor-post-url__link-label"},"🔵 ",Object(a.__)("Endpoint Source")),Object(l.createElement)("p",null,Object(l.createElement)(c.ExternalLink,{className:"editor-post-url__link",href:n+"?view=source",target:"_blank"},Object(l.createElement)(l.Fragment,null,Object(l.createElement)("span",{className:"editor-post-url__link-prefix"},r),Object(l.createElement)("span",{className:"editor-post-url__link-slug"},t),Object(l.createElement)("span",{className:"editor-post-url__link-suffix"},i),Object(l.createElement)("span",{className:"editor-endoint-custom-post-url__link-view"},"?view="),Object(l.createElement)("span",{className:"editor-endoint-custom-post-url__link-view-item"},"source"))))),m&&Object(l.createElement)(l.Fragment,null,Object(l.createElement)("hr",null),Object(l.createElement)("div",{className:"editor-post-url"},Object(l.createElement)("h3",{className:"editor-post-url__link-label"},"🟢 ",Object(a.__)("GraphiQL client")),Object(l.createElement)("p",null,Object(l.createElement)(c.ExternalLink,{className:"editor-post-url__link",href:n+"?view=graphiql",target:"_blank"},Object(l.createElement)(l.Fragment,null,Object(l.createElement)("span",{className:"editor-post-url__link-prefix"},r),Object(l.createElement)("span",{className:"editor-post-url__link-slug"},t),Object(l.createElement)("span",{className:"editor-post-url__link-suffix"},i),Object(l.createElement)("span",{className:"editor-endoint-custom-post-url__link-view"},"?view="),Object(l.createElement)("span",{className:"editor-endoint-custom-post-url__link-view-item"},"graphiql")))))),d&&Object(l.createElement)(l.Fragment,null,Object(l.createElement)("hr",null),Object(l.createElement)("div",{className:"editor-post-url"},Object(l.createElement)("h3",{className:"editor-post-url__link-label"},"🟢 ",Object(a.__)("Interactive Schema Client")),Object(l.createElement)("p",null,Object(l.createElement)(c.ExternalLink,{className:"editor-post-url__link",href:n+"?view=schema",target:"_blank"},Object(l.createElement)(l.Fragment,null,Object(l.createElement)("span",{className:"editor-post-url__link-prefix"},r),Object(l.createElement)("span",{className:"editor-post-url__link-slug"},t),Object(l.createElement)("span",{className:"editor-post-url__link-suffix"},i),Object(l.createElement)("span",{className:"editor-endoint-custom-post-url__link-view"},"?view="),Object(l.createElement)("span",{className:"editor-endoint-custom-post-url__link-view-item"},"schema")))))))}n(8);Object(r.registerPlugin)("custom-endpoint-properties-panel",{render:function(){return Object(l.createElement)(i.PluginDocumentSettingPanel,{name:"custom-endpoint-properties-panel",title:Object(a.__)("Custom Endpoint Properties","graphql-api")},Object(l.createElement)(u,null))},icon:"welcome-view-site"})}]);