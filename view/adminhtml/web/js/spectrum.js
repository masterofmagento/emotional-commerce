!function(e){"use strict";"function"==typeof define&&define.amd?define(["jquery"],e):"object"==typeof exports&&"object"==typeof module?module.exports=e(require("jquery")):e(jQuery)}(function(De,qe){"use strict";var e,Ie={beforeShow:a,move:a,change:a,show:a,hide:a,color:!1,flat:!1,type:"",showInput:!1,allowEmpty:!0,showButtons:!0,clickoutFiresChange:!0,showInitial:!1,showPalette:!0,showPaletteOnly:!1,hideAfterPaletteSelect:!1,togglePaletteOnly:!1,showSelectionPalette:!0,localStorageKey:!1,appendTo:"body",maxSelectionSize:8,locale:"en",cancelText:"cancel",chooseText:"choose",togglePaletteMoreText:"more",togglePaletteLessText:"less",clearText:"Clear Color Selection",noColorSelectedText:"No Color Selected",preferredFormat:"name",className:"",containerClassName:"",replacerClassName:"",showAlpha:!0,theme:"sp-light",palette:[["#000000","#444444","#5b5b5b","#999999","#bcbcbc","#eeeeee","#f3f6f4","#ffffff"],["#f44336","#744700","#ce7e00","#8fce00","#2986cc","#16537e","#6a329f","#c90076"],["#f4cccc","#fce5cd","#fff2cc","#d9ead3","#d0e0e3","#cfe2f3","#d9d2e9","#ead1dc"],["#ea9999","#f9cb9c","#ffe599","#b6d7a8","#a2c4c9","#9fc5e8","#b4a7d6","#d5a6bd"],["#e06666","#f6b26b","#ffd966","#93c47d","#76a5af","#6fa8dc","#8e7cc3","#c27ba0"],["#cc0000","#e69138","#f1c232","#6aa84f","#45818e","#3d85c6","#674ea7","#a64d79"],["#990000","#b45f06","#bf9000","#38761d","#134f5c","#0b5394","#351c75","#741b47"],["#660000","#783f04","#7f6000","#274e13","#0c343d","#073763","#20124d","#4c1130"]],selectionPalette:[],disabled:!1,offset:null},Ve=[],We=!!/msie/i.exec(window.navigator.userAgent),Be=((e=document.createElement("div").style).cssText="background-color:rgba(0,0,0,.5)",t(e.backgroundColor,"rgba")||t(e.backgroundColor,"hsla")),Ke=["<div class='sp-replacer'>","<div class='sp-preview'><div class='sp-preview-inner'></div></div>","<div class='sp-dd'>&#9660;</div>","</div>"].join(""),$e=function(){var e="";if(We)for(var t=1;t<=6;t++)e+="<div class='sp-"+t+"'></div>";return["<div class='sp-container sp-hidden'>","<div class='sp-palette-container'>","<div class='sp-palette sp-thumb sp-cf'></div>","<div class='sp-palette-button-container sp-cf'>","<button type='button' class='sp-palette-toggle'></button>","</div>","</div>","<div class='sp-picker-container'>","<div class='sp-top sp-cf'>","<div class='sp-fill'></div>","<div class='sp-top-inner'>","<div class='sp-color'>","<div class='sp-sat'>","<div class='sp-val'>","<div class='sp-dragger'></div>","</div>","</div>","</div>","<div class='sp-clear sp-clear-display'>","</div>","<div class='sp-hue'>","<div class='sp-slider'></div>",e,"</div>","</div>","<div class='sp-alpha'><div class='sp-alpha-inner'><div class='sp-alpha-handle'></div></div></div>","</div>","<div class='sp-input-container sp-cf'>","<input class='sp-input' type='text' spellcheck='false'  />","</div>","<div class='sp-initial sp-thumb sp-cf'></div>","<div class='sp-button-container sp-cf'>","<button class='sp-cancel' href='#'></button>","<button type='button' class='sp-choose'></button>","</div>","</div>","</div>"].join("")}();function t(e,t){return!!~(""+e).indexOf(t)}function Xe(e,t,a,o){for(var r=[],n=0;n<e.length;n++){var s=e[n];if(s){var i=tinycolor(s),l=i.toHsl().l<.5?"sp-thumb-el sp-thumb-dark":"sp-thumb-el sp-thumb-light";l+=tinycolor.equals(t,s)?" sp-thumb-active":"";var c=i.toString(o.preferredFormat||"rgb"),u=Be?"background-color:"+i.toRgbString():"filter:"+i.toFilter();r.push('<span title="'+c+'" data-color="'+i.toRgbString()+'" class="'+l+'"><span class="sp-thumb-inner" style="'+u+';"></span></span>')}else r.push('<span class="sp-thumb-el sp-clear-display" ><span class="sp-clear-palette-only" style="background-color: transparent;"></span></span>')}return"<div class='sp-cf "+a+"'>"+r.join("")+"</div>"}function n(e,t){var a,o,r,n,h=function(e,t){e.locale=e.locale||window.navigator.language,e.locale&&(e.locale=e.locale.split("-")[0].toLowerCase()),"en"!=e.locale&&De.spectrum.localization[e.locale]&&(e=De.extend({},De.spectrum.localization[e.locale],e));var a=De.extend({},Ie,e);return a.callbacks={move:Ge(a.move,t),change:Ge(a.change,t),show:Ge(a.show,t),hide:Ge(a.hide,t),beforeShow:Ge(a.beforeShow,t)},a}(t,e),s=h.type,d="flat"==s,i=h.showSelectionPalette,l=h.localStorageKey,c=h.theme,u=h.callbacks,f=(a=Qe,function(){var e=this,t=arguments;r&&clearTimeout(n),!r&&n||(n=setTimeout(function(){n=null,a.apply(e,t)},o))}),p=!(o=10),g=!1,b=0,m=0,v=0,x=0,y=0,T=0,w=0,_=0,k=0,P=0,C=1,S=[],M=[],z={},j=h.selectionPalette.slice(0),A=h.maxSelectionSize,R="sp-dragging",F=!1,H=null,L=e.ownerDocument,O=(L.body,De(e)),Q=!1,E=De($e,L).addClass(c),N=E.find(".sp-picker-container"),D=E.find(".sp-color"),q=E.find(".sp-dragger"),I=E.find(".sp-hue"),V=E.find(".sp-slider"),W=E.find(".sp-alpha-inner"),B=E.find(".sp-alpha"),K=E.find(".sp-alpha-handle"),$=E.find(".sp-input"),X=E.find(".sp-palette"),Y=E.find(".sp-initial"),G=E.find(".sp-cancel"),U=E.find(".sp-clear"),J=E.find(".sp-choose"),Z=E.find(".sp-palette-toggle"),ee=O.is("input"),te=(ee&&"color"===O.attr("type")&&Je(),ee&&"color"==s),ae=te?De(Ke).addClass(c).addClass(h.className).addClass(h.replacerClassName):De([]),oe=te?ae:O,re=ae.find(".sp-preview-inner"),ne=h.color||ee&&O.val(),se=!1,ie=h.preferredFormat,le=!h.showButtons||h.clickoutFiresChange,ce=!ne,ue=h.allowEmpty,fe=null,he=null,de=null,pe=null,ge=O.attr("id");if(ge!==qe&&0<ge.length){var be=De('label[for="'+ge+'"]');be.length&&be.on("click",function(e){return e.preventDefault(),O.spectrum("show"),!1})}function me(){if(h.showPaletteOnly&&(h.showPalette=!0),Z.text(h.showPaletteOnly?h.togglePaletteMoreText:h.togglePaletteLessText),h.palette){S=h.palette.slice(0),M=De.isArray(S[0])?S:[S],z={};for(var e=0;e<M.length;e++)for(var t=0;t<M[e].length;t++){var a=tinycolor(M[e][t]).toRgbString();z[a]=!0}h.showPaletteOnly&&!ne&&(ne=""===S[0][0]?S[0][0]:Object.keys(z)[0])}E.toggleClass("sp-flat",d),E.toggleClass("sp-input-disabled",!h.showInput),E.toggleClass("sp-alpha-enabled",h.showAlpha),E.toggleClass("sp-clear-enabled",ue),E.toggleClass("sp-buttons-disabled",!h.showButtons),E.toggleClass("sp-palette-buttons-disabled",!h.togglePaletteOnly),E.toggleClass("sp-palette-disabled",!h.showPalette),E.toggleClass("sp-palette-only",h.showPaletteOnly),E.toggleClass("sp-initial-disabled",!h.showInitial),E.addClass(h.className).addClass(h.containerClassName),Qe()}function ve(){if(l){try{var e=window.localStorage,t=e[l].split(",#");1<t.length&&(delete e[l],De.each(t,function(e,t){xe(t)}))}catch(e){}try{j=window.localStorage[l].split(";")}catch(e){}}}function xe(e){if(i){var t=tinycolor(e).toRgbString();if(!z[t]&&-1===De.inArray(t,j))for(j.push(t);j.length>A;)j.shift();if(l)try{window.localStorage[l]=j.join(";")}catch(e){}}}function ye(){var a=Re(),e=De.map(M,function(e,t){return Xe(e,a,"sp-palette-row sp-palette-row-"+t,h)});ve(),j&&e.push(Xe(function(){var e=[];if(h.showPalette)for(var t=0;t<j.length;t++){var a=tinycolor(j[t]).toRgbString();z[a]||e.push(j[t])}return e.reverse().slice(0,h.maxSelectionSize)}(),a,"sp-palette-row sp-palette-row-selection",h)),X.html(e.join(""))}function Te(){if(h.showInitial){var e=se,t=Re();Y.html(Xe([e,t],t,"sp-palette-row-initial",h))}}function we(){(m<=0||b<=0||x<=0)&&Qe(),g=!0,E.addClass(R),H=null,O.trigger("dragstart.spectrum",[Re()])}function _e(){g=!1,E.removeClass(R),O.trigger("dragstop.spectrum",[Re()])}function ke(e){if(F)F=!1;else if(null!==e&&""!==e||!ue){var t=tinycolor(e);t.isValid()?(Ae(t),Fe(),Oe()):$.addClass("sp-validation-error")}else Ae(null),Fe(),Oe()}function Pe(){(p?ze:Ce)()}function Ce(){var e=De.Event("beforeShow.spectrum");p?Qe():(O.trigger(e,[Re()]),!1===u.beforeShow(Re())||e.isDefaultPrevented()||(function(){for(var e=0;e<Ve.length;e++)Ve[e]&&Ve[e].hide()}(),p=!0,De(L).on("keydown.spectrum",Se),De(L).on("click.spectrum",Me),De(window).on("resize.spectrum",f),ae.addClass("sp-active"),E.removeClass("sp-hidden"),Qe(),He(),se=Re(),Te(),u.show(se),O.trigger("show.spectrum",[se])))}function Se(e){27===e.keyCode&&ze()}function Me(e){2!=e.button&&(g||(le?Oe(!0):je(),ze()))}function ze(){p&&!d&&(p=!1,De(L).off("keydown.spectrum",Se),De(L).off("click.spectrum",Me),De(window).off("resize.spectrum",f),ae.removeClass("sp-active"),E.addClass("sp-hidden"),u.hide(Re()),O.trigger("hide.spectrum",[Re()]))}function je(){Ae(se,!0),Oe(!0)}function Ae(e,t){var a,o;tinycolor.equals(e,Re())?He():(e&&e!==qe||!ue?(ce=!1,o=(a=tinycolor(e)).toHsv(),_=o.h%360/360,k=o.s,P=o.v,C=o.a):ce=!0,He(),a&&a.isValid()&&!t&&(ie=h.preferredFormat||a.getFormat()))}function Re(e){return e=e||{},ue&&ce?null:tinycolor.fromRatio({h:_,s:k,v:P,a:Math.round(1e3*C)/1e3},{format:e.format||ie})}function Fe(){He(),u.move(Re()),O.trigger("move.spectrum",[Re()])}function He(){$.removeClass("sp-validation-error"),Le();var e=tinycolor.fromRatio({h:_,s:1,v:1});D.css("background-color",e.toHexString());var t=ie;C<1&&(0!==C||"name"!==t)&&("hex"!==t&&"hex3"!==t&&"hex6"!==t&&"name"!==t||(t="rgb"));var a=Re({format:t}),o="";if(re.removeClass("sp-clear-display"),re.css("background-color","transparent"),!a&&ue)re.addClass("sp-clear-display");else{var r=a.toHexString(),n=a.toRgbString();if(Be||1===a.alpha?re.css("background-color",n):(re.css("background-color","transparent"),re.css("filter",a.toFilter())),h.showAlpha){var s=a.toRgb();s.a=0;var i=tinycolor(s).toRgbString(),l="linear-gradient(left, "+i+", "+r+")";We?W.css("filter",tinycolor(i).toFilter({gradientType:1},r)):(W.css("background","-webkit-"+l),W.css("background","-moz-"+l),W.css("background","-ms-"+l),W.css("background","linear-gradient(to right, "+i+", "+r+")"))}o=a.toString(t)}if(h.showInput&&$.val(o),O.val(o),"text"==h.type||"component"==h.type){var c=a;if(c&&he){var u=c.isLight()||c.getAlpha()<.4?"black":"white";he.css("background-color",c.toRgbString()).css("color",u)}else he.css("background-color",pe).css("color",de)}h.showPalette&&ye(),Te()}function Le(){var e=k,t=P;if(ue&&ce)K.hide(),V.hide(),q.hide();else{K.show(),V.show(),q.show();var a=e*b,o=m-t*m;a=Math.max(-v,Math.min(b-v,a-v)),o=Math.max(-v,Math.min(m-v,o-v)),q.css({top:o+"px",left:a+"px"});var r=C*y;K.css({left:r-T/2+"px"});var n=_*x;V.css({top:n-w+"px"})}}function Oe(e){var t=Re(),a=!tinycolor.equals(t,se);t&&(t.toString(ie),xe(t)),e&&a&&(u.change(t),F=!0,O.trigger("change",[t]))}function Qe(){var e,t,a,o,r,n,s,i,l,c,u,f;p&&(b=D.width(),m=D.height(),v=q.height(),I.width(),x=I.height(),w=V.height(),y=B.width(),T=K.width(),d||(E.css("position","absolute"),h.offset?E.offset(h.offset):E.offset((t=oe,a=(e=E).outerWidth(),o=e.outerHeight(),r=t.outerHeight(),n=e[0].ownerDocument,s=n.documentElement,i=s.clientWidth+De(n).scrollLeft(),l=s.clientHeight+De(n).scrollTop(),c=t.offset(),u=c.left,f=c.top,f+=r,u-=Math.min(u,i<u+a&&a<i?Math.abs(u+a-i):0),{top:f-=Math.min(f,l<f+o&&o<l?Math.abs(+(o+r)):0),bottom:c.bottom,left:u,right:c.right,width:c.width,height:c.height}))),Le(),h.showPalette&&ye(),O.trigger("reflow.spectrum"))}function Ee(){ze(),Q=!0,O.attr("disabled",!0),oe.addClass("sp-disabled")}!function(){if(We&&E.find("*:not(input)").attr("unselectable","on"),me(),fe=De('<span class="sp-original-input-container"></span>'),["margin"].forEach(function(e){fe.css(e,O.css(e))}),"block"==O.css("display")&&fe.css("display","flex"),te)O.after(ae).hide();else if("text"==s)fe.addClass("sp-colorize-container"),O.addClass("spectrum sp-colorize").wrap(fe);else if("component"==s){O.addClass("spectrum").wrap(fe);var e=De(["<div class='sp-colorize-container sp-add-on'>","<div class='sp-colorize'></div> ","</div>"].join(""));e.width(O.outerHeight()+"px").css("border-radius",O.css("border-radius")).css("border",O.css("border")),O.addClass("with-add-on").before(e)}if(he=O.parent().find(".sp-colorize"),de=he.css("color"),pe=he.css("background-color"),ue||U.hide(),d)O.after(E).hide();else{var t="parent"===h.appendTo?O.parent():De(h.appendTo);1!==t.length&&(t=De("body")),t.append(E)}function a(e){return e.data&&e.data.ignore?(Ae(De(e.target).closest(".sp-thumb-el").data("color")),Fe()):(Ae(De(e.target).closest(".sp-thumb-el").data("color")),Fe(),h.hideAfterPaletteSelect?(Oe(!0),ze()):Oe()),!1}ve(),oe.on("click.spectrum touchstart.spectrum",function(e){Q||Pe(),e.stopPropagation(),De(e.target).is("input")||e.preventDefault()}),!O.is(":disabled")&&!0!==h.disabled||Ee(),E.click(Ye),[$,O].forEach(function(t){t.change(function(){ke(t.val())}),t.on("paste",function(){setTimeout(function(){ke(t.val())},1)}),t.keydown(function(e){13==e.keyCode&&(ke(De(t).val()),t==O&&ze())})}),G.text(h.cancelText),G.on("click.spectrum",function(e){e.stopPropagation(),e.preventDefault(),je(),ze()}),U.attr("title",h.clearText),U.on("click.spectrum",function(e){e.stopPropagation(),e.preventDefault(),ce=!0,Fe(),d&&Oe(!0)}),J.text(h.chooseText),J.on("click.spectrum",function(e){e.stopPropagation(),e.preventDefault(),We&&$.is(":focus")&&$.trigger("change"),$.hasClass("sp-validation-error")||(Oe(!0),ze())}),Z.text(h.showPaletteOnly?h.togglePaletteMoreText:h.togglePaletteLessText),Z.on("click.spectrum",function(e){e.stopPropagation(),e.preventDefault(),h.showPaletteOnly=!h.showPaletteOnly,h.showPaletteOnly||d||E.css("left","-="+(N.outerWidth(!0)+5)),me()}),Ue(B,function(e,t,a){C=e/y,ce=!1,a.shiftKey&&(C=Math.round(10*C)/10),Fe()},we,_e),Ue(I,function(e,t){_=parseFloat(t/x),ce=!1,h.showAlpha||(C=1),Fe()},we,_e),Ue(D,function(e,t,a){if(a.shiftKey){if(!H){var o=k*b,r=m-P*m,n=Math.abs(e-o)>Math.abs(t-r);H=n?"x":"y"}}else H=null;var s=!H||"y"===H;H&&"x"!==H||(k=parseFloat(e/b)),s&&(P=parseFloat((m-t)/m)),ce=!1,h.showAlpha||(C=1),Fe()},we,_e),ne?(Ae(ne),He(),ie=tinycolor(ne).format||h.preferredFormat,xe(ne)):(""===ne&&Ae(ne),He()),d&&Ce();var o=We?"mousedown.spectrum":"click.spectrum touchstart.spectrum";X.on(o,".sp-thumb-el",a),Y.on(o,".sp-thumb-el:nth-child(1)",{ignore:!0},a)}();var Ne={show:Ce,hide:ze,toggle:Pe,reflow:Qe,option:function(e,t){return e===qe?De.extend({},h):t===qe?h[e]:(h[e]=t,"preferredFormat"===e&&(ie=h.preferredFormat),void me())},enable:function(){Q=!1,O.attr("disabled",!1),oe.removeClass("sp-disabled")},disable:Ee,offset:function(e){h.offset=e,Qe()},set:function(e){Ae(e),Oe()},get:Re,destroy:function(){O.show().removeClass("spectrum with-add-on sp-colorize"),oe.off("click.spectrum touchstart.spectrum"),E.remove(),ae.remove(),he&&he.css("background-color",pe).css("color",de);var e=O.closest(".sp-original-input-container");0<e.length&&e.after(O).remove(),Ve[Ne.id]=null},container:E};return Ne.id=Ve.push(Ne)-1,Ne}function a(){}function Ye(e){e.stopPropagation()}function Ge(e,t){var a=Array.prototype.slice,o=a.call(arguments,2);return function(){return e.apply(t,o.concat(a.call(arguments)))}}function Ue(s,i,t,e){i=i||function(){},t=t||function(){},e=e||function(){};var l=document,c=!1,u={},f=0,h=0,d="ontouchstart"in window,a={};function p(e){e.stopPropagation&&e.stopPropagation(),e.preventDefault&&e.preventDefault(),e.returnValue=!1}function o(e){if(c){if(We&&l.documentMode<9&&!e.button)return g();var t=e.originalEvent&&e.originalEvent.touches&&e.originalEvent.touches[0],a=t&&t.pageX||e.pageX,o=t&&t.pageY||e.pageY,r=Math.max(0,Math.min(a-u.left,h)),n=Math.max(0,Math.min(o-u.top,f));d&&p(e),i.apply(s,[r,n,e])}}function g(){c&&(De(l).off(a),De(l.body).removeClass("sp-dragging"),setTimeout(function(){e.apply(s,arguments)},0)),c=!1}a.selectstart=p,a.dragstart=p,a["touchmove mousemove"]=o,a["touchend mouseup"]=g,De(s).on("touchstart mousedown",function(e){(e.which?3==e.which:2==e.button)||c||!1!==t.apply(s,arguments)&&(c=!0,f=De(s).height(),h=De(s).width(),u=De(s).offset(),De(l).on(a),De(l.body).addClass("sp-dragging"),o(e),p(e))})}function Je(){return De.fn.spectrum.inputTypeColorSupport()}var s="spectrum.id";De.fn.spectrum=function(a,e){if("string"!=typeof a)return this.spectrum("destroy").each(function(){var e=De.extend({},De(this).data(),a);De(this).is("input")?e.flat||"flat"==e.type?e.type="flat":"color"==De(this).attr("type")?e.type="color":e.type=e.type||"component":e.type="noInput";var t=n(this,e);De(this).data(s,t.id)});var o=this,r=Array.prototype.slice.call(arguments,1);return this.each(function(){var e=Ve[De(this).data(s)];if(e){var t=e[a];if(!t)throw new Error("Spectrum: no such method: '"+a+"'");"get"==a?o=e.get():"container"==a?o=e.container:"option"==a?o=e.option.apply(e,r):"destroy"==a?(e.destroy(),De(this).removeData(s)):t.apply(e,r)}}),o},De.fn.spectrum.load=!0,De.fn.spectrum.loadOpts={},De.fn.spectrum.draggable=Ue,De.fn.spectrum.defaults=Ie,De.fn.spectrum.inputTypeColorSupport=function e(){if(void 0===e._cachedResult){var t=De("<input type='color'/>")[0];e._cachedResult="color"===t.type&&""!==t.value}return e._cachedResult},De.spectrum={},De.spectrum.localization={},De.spectrum.palettes={},De.fn.spectrum.processNativeColorInputs=function(){var e=De("input[type=color]");e.length&&!Je()&&e.spectrum({preferredFormat:"hex6"})},function(){var n=/^[\s,#]+/,s=/\s+$/,o=0,c=Math,i=c.round,u=c.min,f=c.max,e=c.random,h=function(e,t){if(t=t||{},(e=e||"")instanceof h)return e;if(!(this instanceof h))return new h(e,t);var a=function(e){var t={r:0,g:0,b:0},a=1,o=!1,r=!1;"string"==typeof e&&(e=function(e){e=e.replace(n,"").replace(s,"").toLowerCase();var t,a=!1;if(C[e])e=C[e],a=!0;else if("transparent"==e)return{r:0,g:0,b:0,a:0,format:"name"};if(t=Q.rgb.exec(e))return{r:t[1],g:t[2],b:t[3]};if(t=Q.rgba.exec(e))return{r:t[1],g:t[2],b:t[3],a:t[4]};if(t=Q.hsl.exec(e))return{h:t[1],s:t[2],l:t[3]};if(t=Q.hsla.exec(e))return{h:t[1],s:t[2],l:t[3],a:t[4]};if(t=Q.hsv.exec(e))return{h:t[1],s:t[2],v:t[3]};if(t=Q.hsva.exec(e))return{h:t[1],s:t[2],v:t[3],a:t[4]};if(t=Q.hex8.exec(e))return{a:function(e){return A(e)/255}(t[1]),r:A(t[2]),g:A(t[3]),b:A(t[4]),format:a?"name":"hex8"};if(t=Q.hex6.exec(e))return{r:A(t[1]),g:A(t[2]),b:A(t[3]),format:a?"name":"hex"};if(t=Q.hex3.exec(e))return{r:A(t[1]+""+t[1]),g:A(t[2]+""+t[2]),b:A(t[3]+""+t[3]),format:a?"name":"hex"};return!1}(e));"object"==typeof e&&(e.hasOwnProperty("r")&&e.hasOwnProperty("g")&&e.hasOwnProperty("b")?(t=function(e,t,a){return{r:255*z(e,255),g:255*z(t,255),b:255*z(a,255)}}(e.r,e.g,e.b),o=!0,r="%"===String(e.r).substr(-1)?"prgb":"rgb"):e.hasOwnProperty("h")&&e.hasOwnProperty("s")&&e.hasOwnProperty("v")?(e.s=F(e.s),e.v=F(e.v),t=function(e,t,a){e=6*z(e,360),t=z(t,100),a=z(a,100);var o=c.floor(e),r=e-o,n=a*(1-t),s=a*(1-r*t),i=a*(1-(1-r)*t),l=o%6;return{r:255*[a,s,n,n,i,a][l],g:255*[i,a,a,s,n,n][l],b:255*[n,n,i,a,a,s][l]}}(e.h,e.s,e.v),o=!0,r="hsv"):e.hasOwnProperty("h")&&e.hasOwnProperty("s")&&e.hasOwnProperty("l")&&(e.s=F(e.s),e.l=F(e.l),t=function(e,t,a){var o,r,n;function s(e,t,a){return a<0&&(a+=1),1<a&&--a,a<1/6?e+6*(t-e)*a:a<.5?t:a<2/3?e+(t-e)*(2/3-a)*6:e}if(e=z(e,360),t=z(t,100),a=z(a,100),0===t)o=r=n=a;else{var i=a<.5?a*(1+t):a+t-a*t,l=2*a-i;o=s(l,i,e+1/3),r=s(l,i,e),n=s(l,i,e-1/3)}return{r:255*o,g:255*r,b:255*n}}(e.h,e.s,e.l),o=!0,r="hsl"),e.hasOwnProperty("a")&&(a=e.a));return a=M(a),{ok:o,format:e.format||r,r:u(255,f(t.r,0)),g:u(255,f(t.g,0)),b:u(255,f(t.b,0)),a:a}}(e);this._originalInput=e,this._r=a.r,this._g=a.g,this._b=a.b,this._a=a.a,this._roundA=i(1e3*this._a)/1e3,this._format=t.format||a.format,this._gradientType=t.gradientType,this._r<1&&(this._r=i(this._r)),this._g<1&&(this._g=i(this._g)),this._b<1&&(this._b=i(this._b)),this._ok=a.ok,this._tc_id=o++};function r(e,t,a){e=z(e,255),t=z(t,255),a=z(a,255);var o,r,n=f(e,t,a),s=u(e,t,a),i=(n+s)/2;if(n==s)o=r=0;else{var l=n-s;switch(r=.5<i?l/(2-n-s):l/(n+s),n){case e:o=(t-a)/l+(t<a?6:0);break;case t:o=(a-e)/l+2;break;case a:o=(e-t)/l+4}o/=6}return{h:o,s:r,l:i}}function l(e,t,a){e=z(e,255),t=z(t,255),a=z(a,255);var o,r,n=f(e,t,a),s=u(e,t,a),i=n,l=n-s;if(r=0===n?0:l/n,n==s)o=0;else{switch(n){case e:o=(t-a)/l+(t<a?6:0);break;case t:o=(a-e)/l+2;break;case a:o=(e-t)/l+4}o/=6}return{h:o,s:r,v:i}}function t(e,t,a,o){var r=[R(i(e).toString(16)),R(i(t).toString(16)),R(i(a).toString(16))];return o&&r[0].charAt(0)==r[0].charAt(1)&&r[1].charAt(0)==r[1].charAt(1)&&r[2].charAt(0)==r[2].charAt(1)?r[0].charAt(0)+r[1].charAt(0)+r[2].charAt(0):r.join("")}function d(e,t,a,o){var r;return[R((r=o,Math.round(255*parseFloat(r)).toString(16))),R(i(e).toString(16)),R(i(t).toString(16)),R(i(a).toString(16))].join("")}function a(e,t){t=0===t?0:t||10;var a=h(e).toHsl();return a.s-=t/100,a.s=j(a.s),h(a)}function p(e,t){t=0===t?0:t||10;var a=h(e).toHsl();return a.s+=t/100,a.s=j(a.s),h(a)}function g(e){return h(e).desaturate(100)}function b(e,t){t=0===t?0:t||10;var a=h(e).toHsl();return a.l+=t/100,a.l=j(a.l),h(a)}function m(e,t){t=0===t?0:t||10;var a=h(e).toRgb();return a.r=f(0,u(255,a.r-i(-t/100*255))),a.g=f(0,u(255,a.g-i(-t/100*255))),a.b=f(0,u(255,a.b-i(-t/100*255))),h(a)}function v(e,t){t=0===t?0:t||10;var a=h(e).toHsl();return a.l-=t/100,a.l=j(a.l),h(a)}function x(e,t){var a=h(e).toHsl(),o=(i(a.h)+t)%360;return a.h=o<0?360+o:o,h(a)}function y(e){var t=h(e).toHsl();return t.h=(t.h+180)%360,h(t)}function T(e){var t=h(e).toHsl(),a=t.h;return[h(e),h({h:(a+120)%360,s:t.s,l:t.l}),h({h:(a+240)%360,s:t.s,l:t.l})]}function w(e){var t=h(e).toHsl(),a=t.h;return[h(e),h({h:(a+90)%360,s:t.s,l:t.l}),h({h:(a+180)%360,s:t.s,l:t.l}),h({h:(a+270)%360,s:t.s,l:t.l})]}function _(e){var t=h(e).toHsl(),a=t.h;return[h(e),h({h:(a+72)%360,s:t.s,l:t.l}),h({h:(a+216)%360,s:t.s,l:t.l})]}function k(e,t,a){t=t||6,a=a||30;var o=h(e).toHsl(),r=360/a,n=[h(e)];for(o.h=(o.h-(r*t>>1)+720)%360;--t;)o.h=(o.h+r)%360,n.push(h(o));return n}function P(e,t){t=t||6;for(var a=h(e).toHsv(),o=a.h,r=a.s,n=a.v,s=[],i=1/t;t--;)s.push(h({h:o,s:r,v:n})),n=(n+i)%1;return s}h.prototype={isDark:function(){return this.getBrightness()<128},isLight:function(){return!this.isDark()},isValid:function(){return this._ok},getOriginalInput:function(){return this._originalInput},getFormat:function(){return this._format},getAlpha:function(){return this._a},getBrightness:function(){var e=this.toRgb();return(299*e.r+587*e.g+114*e.b)/1e3},setAlpha:function(e){return this._a=M(e),this._roundA=i(1e3*this._a)/1e3,this},toHsv:function(){var e=l(this._r,this._g,this._b);return{h:360*e.h,s:e.s,v:e.v,a:this._a}},toHsvString:function(){var e=l(this._r,this._g,this._b),t=i(360*e.h),a=i(100*e.s),o=i(100*e.v);return 1==this._a?"hsv("+t+", "+a+"%, "+o+"%)":"hsva("+t+", "+a+"%, "+o+"%, "+this._roundA+")"},toHsl:function(){var e=r(this._r,this._g,this._b);return{h:360*e.h,s:e.s,l:e.l,a:this._a}},toHslString:function(){var e=r(this._r,this._g,this._b),t=i(360*e.h),a=i(100*e.s),o=i(100*e.l);return 1==this._a?"hsl("+t+", "+a+"%, "+o+"%)":"hsla("+t+", "+a+"%, "+o+"%, "+this._roundA+")"},toHex:function(e){return t(this._r,this._g,this._b,e)},toHexString:function(e){return"#"+this.toHex(e)},toHex8:function(){return d(this._r,this._g,this._b,this._a)},toHex8String:function(){return"#"+this.toHex8()},toRgb:function(){return{r:i(this._r),g:i(this._g),b:i(this._b),a:this._a}},toRgbString:function(){return 1==this._a?"rgb("+i(this._r)+", "+i(this._g)+", "+i(this._b)+")":"rgba("+i(this._r)+", "+i(this._g)+", "+i(this._b)+", "+this._roundA+")"},toPercentageRgb:function(){return{r:i(100*z(this._r,255))+"%",g:i(100*z(this._g,255))+"%",b:i(100*z(this._b,255))+"%",a:this._a}},toPercentageRgbString:function(){return 1==this._a?"rgb("+i(100*z(this._r,255))+"%, "+i(100*z(this._g,255))+"%, "+i(100*z(this._b,255))+"%)":"rgba("+i(100*z(this._r,255))+"%, "+i(100*z(this._g,255))+"%, "+i(100*z(this._b,255))+"%, "+this._roundA+")"},toName:function(){return 0===this._a?"transparent":!(this._a<1)&&(S[t(this._r,this._g,this._b,!0)]||!1)},toFilter:function(e){var t="#"+d(this._r,this._g,this._b,this._a),a=t,o=this._gradientType?"GradientType = 1, ":"";e&&(a=h(e).toHex8String());return"progid:DXImageTransform.Microsoft.gradient("+o+"startColorstr="+t+",endColorstr="+a+")"},toString:function(e){var t=!!e;e=e||this._format;var a=!1,o=this._a<1&&0<=this._a;return t||!o||"hex"!==e&&"hex6"!==e&&"hex3"!==e&&"name"!==e?("rgb"===e&&(a=this.toRgbString()),"prgb"===e&&(a=this.toPercentageRgbString()),"hex"!==e&&"hex6"!==e||(a=this.toHexString()),"hex3"===e&&(a=this.toHexString(!0)),"hex8"===e&&(a=this.toHex8String()),"name"===e&&(a=this.toName()),"hsl"===e&&(a=this.toHslString()),"hsv"===e&&(a=this.toHsvString()),a||this.toHexString()):"name"===e&&0===this._a?this.toName():this.toRgbString()},_applyModification:function(e,t){var a=e.apply(null,[this].concat([].slice.call(t)));return this._r=a._r,this._g=a._g,this._b=a._b,this.setAlpha(a._a),this},lighten:function(){return this._applyModification(b,arguments)},brighten:function(){return this._applyModification(m,arguments)},darken:function(){return this._applyModification(v,arguments)},desaturate:function(){return this._applyModification(a,arguments)},saturate:function(){return this._applyModification(p,arguments)},greyscale:function(){return this._applyModification(g,arguments)},spin:function(){return this._applyModification(x,arguments)},_applyCombination:function(e,t){return e.apply(null,[this].concat([].slice.call(t)))},analogous:function(){return this._applyCombination(k,arguments)},complement:function(){return this._applyCombination(y,arguments)},monochromatic:function(){return this._applyCombination(P,arguments)},splitcomplement:function(){return this._applyCombination(_,arguments)},triad:function(){return this._applyCombination(T,arguments)},tetrad:function(){return this._applyCombination(w,arguments)}},h.fromRatio=function(e,t){if("object"==typeof e){var a={};for(var o in e)e.hasOwnProperty(o)&&(a[o]="a"===o?e[o]:F(e[o]));e=a}return h(e,t)},h.equals=function(e,t){return!(!e||!t)&&h(e).toRgbString()==h(t).toRgbString()},h.random=function(){return h.fromRatio({r:e(),g:e(),b:e()})},h.mix=function(e,t,a){a=0===a?0:a||50;var o,r=h(e).toRgb(),n=h(t).toRgb(),s=a/100,i=2*s-1,l=n.a-r.a,c=1-(o=((o=i*l==-1?i:(i+l)/(1+i*l))+1)/2),u={r:n.r*o+r.r*c,g:n.g*o+r.g*c,b:n.b*o+r.b*c,a:n.a*s+r.a*(1-s)};return h(u)},h.readability=function(e,t){var a=h(e),o=h(t),r=a.toRgb(),n=o.toRgb(),s=a.getBrightness(),i=o.getBrightness(),l=Math.max(r.r,n.r)-Math.min(r.r,n.r)+Math.max(r.g,n.g)-Math.min(r.g,n.g)+Math.max(r.b,n.b)-Math.min(r.b,n.b);return{brightness:Math.abs(s-i),color:l}},h.isReadable=function(e,t){var a=h.readability(e,t);return 125<a.brightness&&500<a.color},h.mostReadable=function(e,t){for(var a=null,o=0,r=!1,n=0;n<t.length;n++){var s=h.readability(e,t[n]),i=125<s.brightness&&500<s.color,l=s.brightness/125*3+s.color/500;(i&&!r||i&&r&&o<l||!i&&!r&&o<l)&&(r=i,o=l,a=h(t[n]))}return a};var C=h.names={aliceblue:"f0f8ff",antiquewhite:"faebd7",aqua:"0ff",aquamarine:"7fffd4",azure:"f0ffff",beige:"f5f5dc",bisque:"ffe4c4",black:"000",blanchedalmond:"ffebcd",blue:"00f",blueviolet:"8a2be2",brown:"a52a2a",burlywood:"deb887",burntsienna:"ea7e5d",cadetblue:"5f9ea0",chartreuse:"7fff00",chocolate:"d2691e",coral:"ff7f50",cornflowerblue:"6495ed",cornsilk:"fff8dc",crimson:"dc143c",cyan:"0ff",darkblue:"00008b",darkcyan:"008b8b",darkgoldenrod:"b8860b",darkgray:"a9a9a9",darkgreen:"006400",darkgrey:"a9a9a9",darkkhaki:"bdb76b",darkmagenta:"8b008b",darkolivegreen:"556b2f",darkorange:"ff8c00",darkorchid:"9932cc",darkred:"8b0000",darksalmon:"e9967a",darkseagreen:"8fbc8f",darkslateblue:"483d8b",darkslategray:"2f4f4f",darkslategrey:"2f4f4f",darkturquoise:"00ced1",darkviolet:"9400d3",deeppink:"ff1493",deepskyblue:"00bfff",dimgray:"696969",dimgrey:"696969",dodgerblue:"1e90ff",firebrick:"b22222",floralwhite:"fffaf0",forestgreen:"228b22",fuchsia:"f0f",gainsboro:"dcdcdc",ghostwhite:"f8f8ff",gold:"ffd700",goldenrod:"daa520",gray:"808080",green:"008000",greenyellow:"adff2f",grey:"808080",honeydew:"f0fff0",hotpink:"ff69b4",indianred:"cd5c5c",indigo:"4b0082",ivory:"fffff0",khaki:"f0e68c",lavender:"e6e6fa",lavenderblush:"fff0f5",lawngreen:"7cfc00",lemonchiffon:"fffacd",lightblue:"add8e6",lightcoral:"f08080",lightcyan:"e0ffff",lightgoldenrodyellow:"fafad2",lightgray:"d3d3d3",lightgreen:"90ee90",lightgrey:"d3d3d3",lightpink:"ffb6c1",lightsalmon:"ffa07a",lightseagreen:"20b2aa",lightskyblue:"87cefa",lightslategray:"789",lightslategrey:"789",lightsteelblue:"b0c4de",lightyellow:"ffffe0",lime:"0f0",limegreen:"32cd32",linen:"faf0e6",magenta:"f0f",maroon:"800000",mediumaquamarine:"66cdaa",mediumblue:"0000cd",mediumorchid:"ba55d3",mediumpurple:"9370db",mediumseagreen:"3cb371",mediumslateblue:"7b68ee",mediumspringgreen:"00fa9a",mediumturquoise:"48d1cc",mediumvioletred:"c71585",midnightblue:"191970",mintcream:"f5fffa",mistyrose:"ffe4e1",moccasin:"ffe4b5",navajowhite:"ffdead",navy:"000080",oldlace:"fdf5e6",olive:"808000",olivedrab:"6b8e23",orange:"ffa500",orangered:"ff4500",orchid:"da70d6",palegoldenrod:"eee8aa",palegreen:"98fb98",paleturquoise:"afeeee",palevioletred:"db7093",papayawhip:"ffefd5",peachpuff:"ffdab9",peru:"cd853f",pink:"ffc0cb",plum:"dda0dd",powderblue:"b0e0e6",purple:"800080",rebeccapurple:"663399",red:"f00",rosybrown:"bc8f8f",royalblue:"4169e1",saddlebrown:"8b4513",salmon:"fa8072",sandybrown:"f4a460",seagreen:"2e8b57",seashell:"fff5ee",sienna:"a0522d",silver:"c0c0c0",skyblue:"87ceeb",slateblue:"6a5acd",slategray:"708090",slategrey:"708090",snow:"fffafa",springgreen:"00ff7f",steelblue:"4682b4",tan:"d2b48c",teal:"008080",thistle:"d8bfd8",tomato:"ff6347",turquoise:"40e0d0",violet:"ee82ee",wheat:"f5deb3",white:"fff",whitesmoke:"f5f5f5",yellow:"ff0",yellowgreen:"9acd32"},S=h.hexNames=function(e){var t={};for(var a in e)e.hasOwnProperty(a)&&(t[e[a]]=a);return t}(C);function M(e){return e=parseFloat(e),(isNaN(e)||e<0||1<e)&&(e=1),e}function z(e,t){var a;"string"==typeof(a=e)&&-1!=a.indexOf(".")&&1===parseFloat(a)&&(e="100%");var o,r="string"==typeof(o=e)&&-1!=o.indexOf("%");return e=u(t,f(0,parseFloat(e))),r&&(e=parseInt(e*t,10)/100),c.abs(e-t)<1e-6?1:e%t/parseFloat(t)}function j(e){return u(1,f(0,e))}function A(e){return parseInt(e,16)}function R(e){return 1==e.length?"0"+e:""+e}function F(e){return e<=1&&(e=100*e+"%"),e}var H,L,O,Q=(L="[\\s|\\(]+("+(H="(?:[-\\+]?\\d*\\.\\d+%?)|(?:[-\\+]?\\d+%?)")+")[,|\\s]+("+H+")[,|\\s]+("+H+")\\s*\\)?",O="[\\s|\\(]+("+H+")[,|\\s]+("+H+")[,|\\s]+("+H+")[,|\\s]+("+H+")\\s*\\)?",{rgb:new RegExp("rgb"+L),rgba:new RegExp("rgba"+O),hsl:new RegExp("hsl"+L),hsla:new RegExp("hsla"+O),hsv:new RegExp("hsv"+L),hsva:new RegExp("hsva"+O),hex3:/^([0-9a-fA-F]{1})([0-9a-fA-F]{1})([0-9a-fA-F]{1})$/,hex6:/^([0-9a-fA-F]{2})([0-9a-fA-F]{2})([0-9a-fA-F]{2})$/,hex8:/^([0-9a-fA-F]{2})([0-9a-fA-F]{2})([0-9a-fA-F]{2})([0-9a-fA-F]{2})$/});window.tinycolor=h}(),De(function(){De.fn.spectrum.load&&De.fn.spectrum.processNativeColorInputs()})}),jQuery.spectrum.localization.ar={cancelText:"إلغاء",chooseText:"إختار",clearText:"إرجاع الألوان على ما كانت",noColorSelectedText:"لم تختار أي لون",togglePaletteMoreText:"أكثر",togglePaletteLessText:"أقل"},jQuery.spectrum.localization.ca={cancelText:"Cancel·lar",chooseText:"Escollir",clearText:"Esborrar color seleccionat",noColorSelectedText:"Cap color seleccionat",togglePaletteMoreText:"Més",togglePaletteLessText:"Menys"},jQuery.spectrum.localization.cs={cancelText:"zrušit",chooseText:"vybrat",clearText:"Resetovat výměr barev",noColorSelectedText:"Žádná barva nebyla vybrána",togglePaletteMoreText:"více",togglePaletteLessText:"méně"},jQuery.spectrum.localization.de={cancelText:"Abbrechen",chooseText:"Wählen",clearText:"Farbauswahl zurücksetzen",noColorSelectedText:"Keine Farbe ausgewählt",togglePaletteMoreText:"Mehr",togglePaletteLessText:"Weniger"},jQuery.spectrum.localization.dk={cancelText:"annuller",chooseText:"Vælg"},jQuery.spectrum.localization.es={cancelText:"Cancelar",chooseText:"Elegir",clearText:"Borrar color seleccionado",noColorSelectedText:"Ningún color seleccionado",togglePaletteMoreText:"Más",togglePaletteLessText:"Menos"},jQuery.spectrum.localization.et={cancelText:"Katkesta",chooseText:"Vali",clearText:"Tühista värvivalik",noColorSelectedText:"Ühtki värvi pole valitud",togglePaletteMoreText:"Rohkem",togglePaletteLessText:"Vähem"},jQuery.spectrum.localization.fa={cancelText:"لغو",chooseText:"انتخاب",clearText:"تنظیم مجدد رنگ",noColorSelectedText:"هیچ رنگی انتخاب نشده است!",togglePaletteMoreText:"بیشتر",togglePaletteLessText:"کمتر"},jQuery.spectrum.localization.fi={cancelText:"Kumoa",chooseText:"Valitse"},jQuery.spectrum.localization.fr={cancelText:"Annuler",chooseText:"Valider",clearText:"Effacer couleur sélectionnée",noColorSelectedText:"Aucune couleur sélectionnée",togglePaletteMoreText:"Plus",togglePaletteLessText:"Moins"},jQuery.spectrum.localization.gr={cancelText:"Ακύρωση",chooseText:"Επιλογή",clearText:"Καθαρισμός επιλεγμένου χρώματος",noColorSelectedText:"Δεν έχει επιλεχθεί κάποιο χρώμα",togglePaletteMoreText:"Περισσότερα",togglePaletteLessText:"Λιγότερα"},jQuery.spectrum.localization.he={cancelText:"בטל בחירה",chooseText:"בחר צבע",clearText:"אפס בחירה",noColorSelectedText:"לא נבחר צבע",togglePaletteMoreText:"עוד צבעים",togglePaletteLessText:"פחות צבעים"},jQuery.spectrum.localization.hr={cancelText:"Odustani",chooseText:"Odaberi",clearText:"Poništi odabir",noColorSelectedText:"Niti jedna boja nije odabrana",togglePaletteMoreText:"Više",togglePaletteLessText:"Manje"},jQuery.spectrum.localization.hu={cancelText:"Mégsem",chooseText:"Mentés",clearText:"A színválasztás visszaállítása",noColorSelectedText:"Nincs szín kijelölve",togglePaletteMoreText:"Több",togglePaletteLessText:"Kevesebb"},jQuery.spectrum.localization.id={cancelText:"Batal",chooseText:"Pilih",clearText:"Hapus Pilihan Warna",noColorSelectedText:"Warna Tidak Dipilih",togglePaletteMoreText:"tambah",togglePaletteLessText:"kurangi"},jQuery.spectrum.localization.it={cancelText:"annulla",chooseText:"scegli",clearText:"Annulla selezione colore",noColorSelectedText:"Nessun colore selezionato"},jQuery.spectrum.localization.ja={cancelText:"中止",chooseText:"選択"},jQuery.spectrum.localization.ko={cancelText:"취소",chooseText:"선택",clearText:"선택 초기화",noColorSelectedText:"선택된 색상 없음",togglePaletteMoreText:"더보기",togglePaletteLessText:"줄이기"},jQuery.spectrum.localization.lt={cancelText:"Atšaukti",chooseText:"Pasirinkti",clearText:"Išvalyti pasirinkimą",noColorSelectedText:"Spalva nepasirinkta",togglePaletteMoreText:"Daugiau",togglePaletteLessText:"Mažiau"},jQuery.spectrum.localization["nb-no"]={cancelText:"Avbryte",chooseText:"Velg",clearText:"Tilbakestill",noColorSelectedText:"Farge er ikke valgt",togglePaletteMoreText:"Mer",togglePaletteLessText:"Mindre"},jQuery.spectrum.localization["nl-nl"]={cancelText:"Annuleer",chooseText:"Kies",clearText:"Wis kleur selectie",togglePaletteMoreText:"Meer",togglePaletteLessText:"Minder"},jQuery.spectrum.localization.pl={cancelText:"Anuluj",chooseText:"Wybierz",clearText:"Usuń wybór koloru",noColorSelectedText:"Nie wybrano koloru",togglePaletteMoreText:"Więcej",togglePaletteLessText:"Mniej"},jQuery.spectrum.localization["pt-br"]={cancelText:"Cancelar",chooseText:"Escolher",clearText:"Limpar cor selecionada",noColorSelectedText:"Nenhuma cor selecionada",togglePaletteMoreText:"Mais",togglePaletteLessText:"Menos"},jQuery.spectrum.localization["pt-pt"]={cancelText:"Cancelar",chooseText:"Escolher",clearText:"Limpar cor seleccionada",noColorSelectedText:"Nenhuma cor seleccionada",togglePaletteMoreText:"Mais",togglePaletteLessText:"Menos"},jQuery.spectrum.localization.ru={cancelText:"Отмена",chooseText:"Выбрать",clearText:"Сбросить",noColorSelectedText:"Цвет не выбран",togglePaletteMoreText:"Ещё",togglePaletteLessText:"Скрыть"},jQuery.spectrum.localization.sv={cancelText:"Avbryt",chooseText:"Välj"},jQuery.spectrum.localization.tr={cancelText:"iptal",chooseText:"tamam"},jQuery.spectrum.localization["zh-cn"]={cancelText:"取消",chooseText:"选择",clearText:"清除",togglePaletteMoreText:"更多选项",togglePaletteLessText:"隐藏",noColorSelectedText:"尚未选择任何颜色"},jQuery.spectrum.localization["zh-tw"]={cancelText:"取消",chooseText:"選擇",clearText:"清除",togglePaletteMoreText:"更多選項",togglePaletteLessText:"隱藏",noColorSelectedText:"尚未選擇任何顏色"};