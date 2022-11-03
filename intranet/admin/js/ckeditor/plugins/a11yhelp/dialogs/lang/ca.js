﻿(function(e,t){var n="ui-effects-";e.effects={effect:{}};(function(e,t){function h(e,t,n){var r=u[t.type]||{};if(e==null){return n||!t.def?null:t.def}e=r.floor?~~e:parseFloat(e);if(isNaN(e)){return t.def}if(r.mod){return(e+r.mod)%r.mod}return 0>e?0:r.max<e?r.max:e}function p(t){var n=s(),r=n._rgba=[];t=t.toLowerCase();c(i,function(e,i){var s,u=i.re.exec(t),a=u&&i.parse(u),f=i.space||"rgba";if(a){s=n[f](a);n[o[f].cache]=s[o[f].cache];r=n._rgba=s._rgba;return false}});if(r.length){if(r.join()==="0,0,0,0"){e.extend(r,l.transparent)}return n}return l[t]}function d(e,t,n){n=(n+1)%1;if(n*6<1){return e+(t-e)*n*6}if(n*2<1){return t}if(n*3<2){return e+(t-e)*(2/3-n)*6}return e}var n="backgroundColor borderBottomColor borderLeftColor borderRightColor borderTopColor color columnRuleColor outlineColor textDecorationColor textEmphasisColor",r=/^([\-+])=\s*(\d+\.?\d*)/,i=[{re:/rgba?\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*(?:,\s*(\d?(?:\.\d+)?)\s*)?\)/,parse:function(e){return[e[1],e[2],e[3],e[4]]}},{re:/rgba?\(\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*(?:,\s*(\d?(?:\.\d+)?)\s*)?\)/,parse:function(e){return[e[1]*2.55,e[2]*2.55,e[3]*2.55,e[4]]}},{re:/#([a-f0-9]{2})([a-f0-9]{2})([a-f0-9]{2})/,parse:function(e){return[parseInt(e[1],16),parseInt(e[2],16),parseInt(e[3],16)]}},{re:/#([a-f0-9])([a-f0-9])([a-f0-9])/,parse:function(e){return[parseInt(e[1]+e[1],16),parseInt(e[2]+e[2],16),parseInt(e[3]+e[3],16)]}},{re:/hsla?\(\s*(\d+(?:\.\d+)?)\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*(?:,\s*(\d?(?:\.\d+)?)\s*)?\)/,space:"hsla",parse:function(e){return[e[1],e[2]/100,e[3]/100,e[4]]}}],s=e.Color=function(t,n,r,i){return new e.Color.fn.parse(t,n,r,i)},o={rgba:{props:{red:{idx:0,type:"byte"},green:{idx:1,type:"byte"},blue:{idx:2,type:"byte"}}},hsla:{props:{hue:{idx:0,type:"degrees"},saturation:{idx:1,type:"percent"},lightness:{idx:2,type:"percent"}}}},u={"byte":{floor:true,max:255},percent:{max:1},degrees:{mod:360,floor:true}},a=s.support={},f=e("<p>")[0],l,c=e.each;f.style.cssText="background-color:rgba(1,1,1,.5)";a.rgba=f.style.backgroundColor.indexOf("rgba")>-1;c(o,function(e,t){t.cache="_"+e;t.props.alpha={idx:3,type:"percent",def:1}});s.fn=e.extend(s.prototype,{parse:function(n,r,i,u){if(n===t){this._rgba=[null,null,null,null];return this}if(n.jquery||n.nodeType){n=e(n).css(r);r=t}var a=this,f=e.type(n),d=this._rgba=[];if(r!==t){n=[n,r,i,u];f="array"}if(f==="string"){return this.parse(p(n)||l._default)}if(f==="array"){c(o.rgba.props,function(e,t){d[t.idx]=h(n[t.idx],t)});return this}if(f==="object"){if(n instanceof s){c(o,function(e,t){if(n[t.cache]){a[t.cache]=n[t.cache].slice()}})}else{c(o,function(t,r){var i=r.cache;c(r.props,function(e,t){if(!a[i]&&r.to){if(e==="alpha"||n[e]==null){return}a[i]=r.to(a._rgba)}a[i][t.idx]=h(n[e],t,true)});if(a[i]&&e.inArray(null,a[i].slice(0,3))<0){a[i][3]=1;if(r.from){a._rgba=r.from(a[i])}}})}return this}},is:function(e){var t=s(e),n=true,r=this;c(o,function(e,i){var s,o=t[i.cache];if(o){s=r[i.cache]||i.to&&i.to(r._rgba)||[];c(i.props,function(e,t){if(o[t.idx]!=null){n=o[t.idx]===s[t.idx];return n}})}return n});return n},_space:function(){var e=[],t=this;c(o,function(n,r){if(t[r.cache]){e.push(n)}});return e.pop()},transition:function(e,t){var n=s(e),r=n._space(),i=o[r],a=this.alpha()===0?s("transparent"):this,f=a[i.cache]||i.to(a._rgba),l=f.slice();n=n[i.cache];c(i.props,func