!function(e){var t={};function r(n){if(t[n])return t[n].exports;var o=t[n]={i:n,l:!1,exports:{}};return e[n].call(o.exports,o,o.exports,r),o.l=!0,o.exports}r.m=e,r.c=t,r.d=function(e,t,n){r.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},r.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},r.t=function(e,t){if(1&t&&(e=r(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var n=Object.create(null);if(r.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)r.d(n,o,function(t){return e[t]}.bind(null,o));return n},r.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return r.d(t,"a",t),t},r.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},r.p="",r(r.s=3)}([function(e,t){e.exports=window.wp.i18n},function(e,t){e.exports=window.wp.element},function(e,t){e.exports=window.wp.blocks},function(e,t,r){"use strict";r.r(t);var n=r(2),o=r(0),i=r(1);Object(n.registerBlockType)("gatographql/not-server-side-registered-block-schema-testing",{title:Object(o.__)("Gato GraphQL: Block for testing the schema (not registered on server-side)","gatographql-testing-schema"),description:Object(o.__)("Test field `CustomPost.blocks`, to see that blocks not registered on the server-side display a warning when parsed","gatographql-testing-schema"),icon:"admin-plugins",attributes:{someAttribute:{type:"boolean",default:!0},someOtherAttribute:{type:"string"},yetAnotherAttribute:{type:"array",default:[]}},edit:function(e){var t=e.className;return Object(i.createElement)("div",{class:t},Object(i.createElement)("p",null,Object(i.createElement)("strong",null,Object(o.__)("This is a block for testing the schema","gatographql-testing-schema"))),Object(i.createElement)("p",null,Object(o.__)("In particular, to test field `CustomPost.blocks`, to see that blocks not registered on the server-side display a warning when parsed.","gatographql-testing-schema")))},save:function(){return null}})}]);